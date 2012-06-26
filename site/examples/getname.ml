(* ************************************************************************** *)
(* Project: Ionis-Users-Informations                                          *)
(* Description: Example of usage of get_name with Curl and XML                *)
(* Author: db0 (db0company@gmail.com, http://db0.fr/)                         *)
(* Latest Version is on GitHub: http://goo.gl/gi6sH                           *)
(* ************************************************************************** *)

(* How to compile this file?                                                  *)
(* ocamlc -I +curl curl.cma -I +xml-light xml-light.cma getname.ml            *)

(* ************************************************************************** *)
(* Configuration                                                              *)
(* ************************************************************************** *)

let my_login = "exampl_e"
let my_ppp_password = "2q4xfcc3"

(* ************************************************************************** *)
(* Curl Get Page                                                              *)
(* ************************************************************************** *)

type content =
  | Text of string
  | Error of string

(* get_text_form_url : string -> content                                      *)
let get_text_form_url url =
  let writer accum data =
    Buffer.add_string accum data;
    String.length data in
  let result = Buffer.create 16384
  and errorBuffer = ref "" in
  Curl.global_init Curl.CURLINIT_GLOBALALL;
  let text =
    try
      let connection = Curl.init () in
      Curl.set_errorbuffer connection errorBuffer;
      Curl.set_writefunction connection (writer result);
      Curl.set_followlocation connection true;
      Curl.set_url connection url;
      Curl.perform connection;
      Curl.cleanup connection;
      Text (Buffer.contents result)
    with
      | Curl.CurlException (_, _, _) -> Error ("Error: " ^ !errorBuffer)
      | Failure s -> Error ("Caught exception: " ^ s) in
  let _ = Curl.global_cleanup () in
  text

(* ************************************************************************** *)
(* XML Parsing                                                                *)
(* ************************************************************************** *)

(* get_name_from_xml : string -> string                                       *)
let get_name_from_xml str =
  let find_element tree name =
    List.find (fun elem -> (Xml.tag elem) = name) (Xml.children tree)
  and get_string elem = Xml.pcdata (List.hd (Xml.children elem)) in
  let tree = Xml.parse_string str in
  let error = get_string (find_element tree "error")
  and result = find_element tree "result" in
  match error with
    | "none" ->
      (try get_string (find_element result "name")
       with _ -> "Empty result")
    | msg    -> "Error: " ^ msg

(* ************************************************************************** *)
(* Get Name!                                                                  *)
(* ************************************************************************** *)

(* get_name login : string -> string                                          *)
let get_name login =
  let url = "http://ws.paysdu42.fr/XML/?action=get_name&auth_login="
    ^ my_login ^ "&auth_password=" ^ my_ppp_password
    ^ "&login=" ^ login in
  match get_text_form_url url with
    | Error s -> prerr_endline s
    | Text s  -> print_endline (get_name_from_xml s)

let _ = get_name "lepage_b"
