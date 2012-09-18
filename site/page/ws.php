<?php

include_once('include/header.php');

$title = 'Web Service';
$description = get_description();
$no_header = true;

$content ='
    <div class="row-fluid">
      <div class="span4">
	<ul class="nav nav-tabs nav-stacked">
	  <li><a href="#https"><img src="img/secure.gif" /> Using HTTPS</a></li>
	  <li><a href="#sources"><img src="img/puzzle.png" /> Sources and contributors</a></li>
	  <li><a href="#formatting">Formatting</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#formatting-ini">INI</a></li>
	      <li><a href="#formatting-json">JSON</a></li>
	      <li><a href="#formatting-xml">XML</a></li>
	      <li><a href="#formatting-php">PHP</a></li>
	    </ul>
	  </li>
	  <li><a href="#check">Do some checking...</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#check-auth">Check authentification</a></li>
	      <li><a href="#check-login">Check if a login exists</a></li>
	      <li><a href="#check-pass">Check Password</a></li>
	    </ul>
	  </li>
	  <li><a href="#get">Get informations!</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#get-login">Get login from uid</a></li>
	      <li><a href="#get-uid">Get Uid</a></li>
	      <li><a href="#get-name">Get Name</a></li>
	      <li><a href="#get-group">Get Group</a></li>
	      <li><a href="#get-school">Get School</a></li>
	      <li><a href="#get-promo">Get Promo</a></li>
	      <li><a href="#get-city">Get City</a></li>
	      <li><a href="#get-report">Get Report Url</a></li>
	      <li><a href="#get-photo">Get Photo Url</a></li>
	      <li><a href="#get-plan">Get .Plan</a></li>
	      <li><a href="#get-phone">Get Phone</a></li>
	      <li><a href="#get-infos">Get all informations</a></li>
	    </ul>
	  </li>
	  <li><a href="#search">Search for users</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#get-search">Search for users by their logins or names</a></li>
	      <li><a href="#get-logins">Search for users by their promo, city and/or school</a></li>
	    </ul>
	  </li>
	  <li><a href="#global">Get global informations</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#get-schools">Get schools</a></li>
	      <li><a href="#get-cities">Get Cities</a></li>
	      <li><a href="#get-promos">Get Promos</a></li>
	    </ul>
	  </li>
	  <li><a href="#error">Errors</a></li>
	  <li><a href="#examples"><img src="img/notes.gif" /> Examples</a></li>
	  <li class="well summary">
	    <ul class="nav nav-list">
	      <li><a href="#examples">PHP</a></li>
	      <li><a href="#examples">sh</a></li>
	      <li><a href="#examples">OCaml</a></li>
	    </ul>
	  </li>
	</ul>
      </div>
      <div class="span8">
	<!-- -------------------------------------------------------------------------------- -->

	<div class="row-fluid">
	  <div class="span8">
            <h2>Introduction</h2>
	    <br />
	    <p>
	      If you want to code your own tool that would need information and want
	      it to be always up to date, you can use the web service from any language.
	      It can provide many different data formats and is easily usable.
	    </p>

	    <i>
	      Informations about students are confidential, so you can get them only
	      if you have a login and a PPP password registered in a Ionis School.
	    </i>
	  </div>
	  <div class="span4">
	    <img src="img/logo_iui.png" style="float: right;" />
	  </div>
	</div>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<!-- -------------------------------------------------------------------------------- -->

	<h2 id="https"><img src="img/secure.gif" /> Using HTTPS</h2>
	<br />

	<p>
	  You can use HTTPS (Secure) for your requests.<br />
	  Just replace <code>http://ws.paysdu42.fr/</code> by <code>https://return.epitech.eu/ws/</code>
	</p>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h2 id="sources"><img src="img/puzzle.png" /> Sources and contributors</h2>
	<br />
	<ul>
	  <li>
	    Sources of this Website and this Web Service are available on
	    <a href="https://github.com/db0company/Ionis-Users-Informations-Web-Service" target="_blank">GitHub</a>.
	  </li>
	  <li>
	    The Web Service is using the PHP Class, also available on
	    <a href="https://github.com/db0company/Ionis-Users-Informations" target="_blank">GitHub</a>.
	  </li>
	</ul>

	<p>
	  Feel free to contribute by forking these projects on GitHub and make pull requests.<br />
	  You can also help us by creating issues for features requests and bugs reports, on GitHub too.
	</p>

	<p>
	  <strong>Contributors:</strong>
	  <a href="http://db0.fr/" target="_blank">db0</a>,
	  <a href="http://korfuri.fr/" target="_blank">Korfuri</a>,
	  <a href="https://github.com/skorpios" target="_blank">Skorpios</a>.
	</p>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

        <h2 id="formatting">Formatting</h2>
	<br />

	<p>
	  This service is available in 4 formats :
	  <ul>
	    <li><a href="http://en.wikipedia.org/wiki/INI_file" target="_blank">INI</a><br />
	      <pre>[action]
action=get_school

[error]
error=none

[result]
login=noel_p
school=epitech</pre>
	    </li>
	    <li><a href="http://en.wikipedia.org/wiki/Json" target="_blank">JSON</a><br />
	      <pre>{
  "action"="get_school",
  "error"="none",
  "result"=
  {
    "login":"noel_p",
    "school":"epitech"
  }
}</pre>
	    </li>
	    <li><a href="http://en.wikipedia.org/wiki/Xml" target="_blank">XML</a><br />
	      <pre>&lt;action&gt;get_school&lt;/action&gt;
&lt;error&gt;none&lt;/error&gt;
&lt;result&gt;
  &lt;login&gt;noel_p&lt;/login&gt;
  &lt;school&gt;epitech&lt;/school&gt;
&lt;/result&gt;</pre>
	    </li>
	    <li><a href="http://php.net/print_r" target="_blank">PHP</a><br />
	      <pre>Array
(
    [action] => get_school
    [error] => none
    [result] => Array
        (
            [login] => noel_p
            [school] => epitech
        )

)</pre>
	    </li>
	  </ul>
	</p>

	<p>
	  Just replace "format" by the format you prefer in your requests.<br />
	  For example, to get the XML format, replace this :
	  <code>GET http://ws.paysdu42.fr/<span class="rb">format</span>/?<span class="r">action</span>=get_school&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=noel_p</code>
	  by this :
	  <code>GET http://ws.paysdu42.fr/<span class="rb">XML</span>/?<span class="r">action</span>=get_school&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=noel_p</code>
	</p>

	<p>
	  The following examples are using INI format because it\'s shorter and human-readable.
	  The "action" and the "error" parts are skipped.
	</p>

	<span class="up">▲ <a href="#top">Back to top</a></span>
        <hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h2 id="check">Do some checking...</h2>
	<br />
	<p>
	  <span class="label label-warning">Warning</span> <span class="warning">Your login and your password MUST be provided, or you will get errors for all your request.</span>
	</p>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="check-auth">Check authentification</h3>

	<p>
	  Simply check authentification.
	</p>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"login"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=login&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3</code>

	<pre>
[error]
error=none

[result]
</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="check-login">Check if a login exists</h3>

	<p>
	  This action check if a login exists.
	</p>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"is_login"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the ionis login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>state : </b>"OK" | "KO"</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=is_login&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=noel_p</code>

	<pre>
[result]
login=noel_p
state=OK</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="check-pass">Check Password</h3>

	<p>
	  This action check if the login and the password match.
	</p>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"check_password"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the ionis login</li>
	  <li><b>password : </b>the PPP password</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>state : </b>"OK" | "KO"</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=check_password&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=noel_p&<span class="r">password</span>=dMkT!$tX</code>

	<pre>
[result]
login=noel_p
state=OK</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />
	<h2 id="get">Get informations!</h2>
	<br />
	<p>
	  <span class="label label-warning">Warning</span> <span class="warning">Your login and your password MUST be provided, or you will get errors for all your request.</span>
	</p>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-login">Get login from uid</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_login_from_uid"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>uid : </b>the uid</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>uid : </b>the uid</li>
	  <li><b>login : </b>the login</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_login_from_uid&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">uid</span>=74695</code>

	<pre>
[result]
uid=74695
login=lepage_b</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-uid">Get Uid</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_uid"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>uid : </b>the uid</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_uid&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=noel_p</code>

	<pre>
[result]
login=noel_p
uid=7055</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-name">Get Name</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_name"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>name : </b>first name and last name</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_name&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>
[result]
login=lepage_b
name=Barbara Lepage</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-group">Get Group</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_group"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>group : </b>the group</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_group&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>
[result]
login=lepage_b
group=epitech_2014</pre>
	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-school">Get School</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_school"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>school : </b>the school</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_school&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>
[result]
login=lepage_b
school=epitech</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-promo">Get Promo</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_promo"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>promo : </b>the promo</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_promo&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>
[result]
login=lepage_b
promo=2014</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-city">Get City</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_city"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>city : </b>the city</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_city&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>
[result]
login=lepage_b
city=Paris</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-report">Get Report Url</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_report_url"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>report_url : </b>the report url on the epitech intranet</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_report_url&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>[result]
login=lepage_b
report_url=http://www.epitech.eu/intra/index.php?section=etudiant&page=rapport&login=lepage_b</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-photo">Get Photo Url</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_photo_url"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>photo_url : </b>the photo url on the epitech intranet</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_photo_url&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>[result]
login=lepage_b
photo_url=http://www.epitech.eu/intra/photos/lepage_b.jpg</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-plan">Get .Plan</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_plan"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>plan : </b>the .plan file in the AFS on public folder</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_plan&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=corfa_u</code>

	<pre>[result]
login=corfa_u
plan=..General

	  Nom:Uriel Corfa
	  Login:corfa_u
	  Pseudo:Korfuri
	  Promo:Epitech 2011
	  Ville:Paris
	  UID:71070

..Activites

	  Assistant/Labs:Astek, Koala, ESL
	  Lieu de travail usuel:Koalab, ESL

..Contact

	  Netsoul:Je ne recois pas les messages ns
	  Tel:06.28.33.53.29
</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-phone">Get Phone</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_phone"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>phone : </b>the phone number in the .plan file</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_phone&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=corfa_u</code>

	<pre>[result]
login=corfa_u
phone=06.28.33.53.29</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-infos">Get all informations</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_infos"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>login : </b>the login</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li><b>login : </b>the login</li>
	  <li><b>uid : </b>the uid</li>
	  <li><b>name : </b>first name and last name</li>
	  <li><b>group : </b>the group</li>
	  <li><b>school : </b>the school</li>
	  <li><b>promo : </b>the promo</li>
	  <li><b>city : </b>the city</li>
	  <li><b>report_url : </b>the report url on the epitech intranet</li>
	  <li><b>photo_url : </b>the photo url on the epitech intranet</li>
	  <li><b>plan : </b>the .plan file in the AFS on public folder</li>
	  <li><b>phone : </b>the phone number in the .plan file</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_infos&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">login</span>=lepage_b</code>

	<pre>[result]
login=lepage_b
uid=74695
name=Barbara Lepage
group=epitech_2014
school=Epitech
promo=2014
city=Paris
report_url=http://www.epitech.eu/intra/index.php?section=etudiant&page=rapport&login=lepage_b
photo_url=http://www.epitech.eu/intra/photos/lepage_b.jpg
plan=06 . 28 . 47 . 13 . 44</pre>

	<!-- -------------------------------------------------------------------------------- -->

	<hr />

	<h2 id="search">Search for users</h2>
	<br />

	<p>
	  <span class="label label-warning">Warning</span> <span class="warning">Please take into account that
	    these two requests allow you to get the entire list of logins and it\'s a huge cost
	    for our server so use it sparingly.</span>
	</p>

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-search">Search for users by their logins or names</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"search"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>query : </b>all or part of a login or name</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li>A list of logins matching the given criteria</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=search&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">query</span>=corfa</code>

	<pre>[result]
1=corfa_a
2=corfa_u
3=corfa_z</pre>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-logins">Search for users by their promo, city and/or school</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_logins"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>(optionnal) school : </b>the requested school</li>
	  <li><b>(optionnal) promo : </b>the requested promo</li>
	  <li><b>(optionnal) city : </b>the requested city</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li>The list of logins in the requested school, promo and/or city</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_logins&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">school</span>=epitech&<span class="r">promo</span>=2014&<span class="r">city</span>=marseille</code>

	<pre>[result]
1=exampl_e
2=carame_l
3=nyanca_t</pre>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<hr />

	<h2 id="global">Get global informations</h2>
	<br />

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-schools">Get schools</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_schools"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>(optionnal) from_database: </b>Must be <b>0</b> (default), if you want to be sure that these schools exists and are real, <b>1</b> if you want to get them from the database (generated automatically so can be a fake school like "tmp", "old", "guest", "prof-adm"...)</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li>The list of schools</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_schools&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3</code>

	<pre>[result]
0="isbp"
1="epitech"
2="epita"
3="ionis"
4="etna"
5="ipsa"
6="eart"
7="supinternet"
8="web"</pre>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-cities">Get Cities</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_cities"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>(optionnal) school: </b>optional parameter to select only cities where the given school is and return value is</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li>The list of cities</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_cities&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">school</span>=eart</code>

	<pre>[result]
0="Paris"
1="Lyon"
2="Nantes"
3="Bordeaux"
4="Lille"</pre>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h3 id="get-promos">Get Promos</h3>

	<h6>Request parameters</h6>
	<ul>
	  <li><b>action : </b>"get_promos"</li>
	  <li><b>auth_login : </b>your ionis login</li>
	  <li><b>auth_password : </b>your PPP password</li>
	  <li><b>(optionnal) school: </b>current promos for the given school (epitech by default)</li>
	  <li><b>(optionnal) from_database: </b>Must be <b>1</b> if you want to get all promos in the database (the school parameter is ignored). Default = <b>0</b>.</li>
	</ul>

	<h6>Answer</h6>
	<ul>
	  <li>The list of promos</li>
	  <li><b>error : </b><a href="#error">See error table</a></li>
	</ul>

	<h6>Example</h6>

	<code>GET http://ws.paysdu42.fr/format/?<span class="r">action</span>=get_promos&<span class="r">auth_login</span>=exampl_e&<span class="r">auth_password</span>=2q4xfcc3&<span class="r">school</span>=etna</code>

	<pre>[result]
0="2013"
1="2014"
2="2015"</pre>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h2 id="error">Errors</h2>
	<br />

	<table class="table table-striped table-bordered">
	  <tbody>
	    <tr>
	      <th>No error</th>
	      <td><pre>none</pre></td>
	    </tr>
	    <tr>
	      <th>A parameter is missing</th>
	      <td><pre>missing_parameters</pre></td>
	    </tr>
	    <tr>
	      <th>Action does not exist</th>
	      <td><pre>unknown_action</pre></td>
	    </tr>
	    <tr>
	      <th>Your login and your password does not match</th>
	      <td><pre>auth_fail</pre></td>
	    </tr>
	  </tbody>
	</table>

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />

	<!-- -------------------------------------------------------------------------------- -->

	<h2 id="examples"><img src="img/notes.gif" /> Examples</h2>
	<br />

	<p>
	  Here are some examples of usage of this web service in various languages.
	  If you use a language that is not on this list and want to have an example
	  or provide your own example, please <a href="contact.php">contact us</a>.
	</p>

	<br />

	<table class="table table-striped table-bordered">
	  <thead>
	    <tr>
	      <th>Language</th>
	      <th>Formatting</th>
	      <th>Action tested</th>
	      <th>Method to get page</th>
	      <th>Download</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <th>PHP</th>
	      <td>INI</td>
	      <td>get_school</td>
	      <td>Curl</td>
	      <td>
		<a href="examples/getschool.php.txt" target="_blank">
		  <button class="btn">
		    Download this example
		  </button>
		</a>
	      </td>
	    </tr>
	    <tr>
	      <th>sh</th>
	      <td>INI</td>
	      <td>get_promo</td>
	      <td>wget</td>
	      <td>
		<a href="examples/getpromo.sh" target="_blank">
		  <button class="btn">
		    Download this example
		  </button>
		</a>
	      </td>
	    </tr>
	    <tr>
	      <th>OCaml</th>
	      <td>XML</td>
	      <td>get_name</td>
	      <td>Curl</td>
	      <td>
		<a href="examples/getname.ml" target="_blank">
		  <button class="btn">
		    Download this example
		  </button>
		</a>
	      </td>
	    </tr>
	  </tbody>
	</table>

	<br />

	<span class="up">▲ <a href="#top">Back to top</a></span>
	<hr />
</div>
</div>
';
