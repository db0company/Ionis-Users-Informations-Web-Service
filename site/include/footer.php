<?php

function	display_footer() {
  echo '
      <hr />
      <footer>
        <p>
	  <br />
	  Ionis-Users-Informations is developped and maintained by 
	  <a href="http://db0.fr/">Barbara Lepage</a>. Code licensed under
	  <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">the Apache License v2.0.</a>.<br />
	  Please <a href="?contact">contact me</a> if you have any question about this service
	  or if you want to be in the "<a href="?who">Who\'s using it?</a>" page.<br />
	  Sources of the project on 
	  <a href="https://github.com/db0company/Ionis-Users-Informations">GitHub</a>.
	  Sources of this website/webservice are also available on
	  <a href="https://github.com/db0company/Ionis-Users-Informations-Web-Service">GitHub</a>.
	  <br />
	  <br />
	</p>
      </footer>

    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/jquery-ui.min.js"></script>
    <script src="bootstrap/js/bootstrap-transition.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
    <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/js/bootstrap-collapse.js"></script>
    <script src="bootstrap/js/bootstrap-carousel.js"></script>
    <script src="bootstrap/js/bootstrap-typeahead.js"></script>

    <script>
      function show(node_name) {
        $("#"+node_name).slideToggle("fast");
      }

      function jumpToAnchor(name) {
        location.hash = "#"+name;
      }

      function add_to_current_value(to_add) {
        if (typeof this.current_value == \'undefined\')
          this.current_value = 0;        
        this.current_value += to_add;
        return this.current_value;
      }

      function element_exists(id) {
        var elt = document.getElementById(id);
        return (elt ? true : false);
      }

      function change_news(new_value) {
        current_value = add_to_current_value(0);
        dir_hide = (new_value < 0 ? "right" : "left");
        dir_show = (new_value < 0 ?  "left" : "right");
        $("#news"+current_value).hide("slide", { direction: dir_hide }, 500,
          function() {
            current_value = add_to_current_value(new_value);
            $("#news"+(current_value)).show("slide", { direction: dir_show }, 500);
           if (current_value > 0)
             $("#previous").show();
           else
             $("#previous").hide();
           if (element_exists("news"+(current_value+1)))
             $("#next").show();
           else
              $("#next").hide();
          });
      }
    </script>

  </body>
</html>
';
  }
