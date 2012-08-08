#!/bin/bash

cd site/ && \

    echo "Installing Bootstrap..." && \
    rm -rf bootstrap feedwriter && \
    wget http://twitter.github.com/bootstrap/assets/bootstrap.zip && \
    unzip bootstrap.zip && \
    rm bootstrap.zip && \
    echo 'Done.' && \

    echo "Installing Bootstrap plugins..." && \
    cd bootstrap/js/ && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-transition.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-alert.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-modal.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-dropdown.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-scrollspy.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-tab.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-button.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-collapse.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-carousel.js && \
    wget http://twitter.github.com/bootstrap/assets/js/bootstrap-typeahead.js && \
    cd ../.. && \
    echo 'Done.' && \

    echo "Installing JQuery..." && \
    wget http://code.jquery.com/jquery.min.js && \
    mv jquery.min.js bootstrap/js/ && \
    wget http://code.jquery.com/ui/1.9.0-beta.1/jquery-ui.min.js && \
    mv jquery-ui.min.js bootstrap/js/ && \
    echo 'Done.' && \

    echo -n "Installing FeedWriter" && \
    wget https://github.com/mibe/FeedWriter/zipball/master && \
    unzip master && \
    rm master && \
    mv mibe-FeedWriter-* feedwriter && \
    echo "Done." && \

    cd ../ws && \

    echo "Installing Ionis-Users-Informations..." && \
    rm -f ionisinfo.class.php && \
    wget "https://raw.github.com/db0company/Ionis-Users-Informations/master/ionisinfo.class.php" && \
    echo "Done." && \

    echo "Edit configuration file..." && \
    $EDITOR 'conf.php' && \
    echo "Done."
