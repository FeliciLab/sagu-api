FROM nimmis/apache-php7
MAINTAINER Victor Magalhães <victor.magalhaes@esp.ce.gov.br>

RUN a2enmod rewrite

ADD docker-config/ /etc/apache2/sites-available

RUN service apache2 stop
RUN service apache2 start