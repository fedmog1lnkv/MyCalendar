FROM mysql:latest

ENV MYSQL_DATABASE=my_calendar
ENV MYSQL_USER=my-calendar-user
ENV MYSQL_PASSWORD=1234
ENV MYSQL_ROOT_PASSWORD=rootpassword

ADD database_scheme.sql /docker-entrypoint-initdb.d/

EXPOSE 3306

CMD ["mysqld", "--init-file=/docker-entrypoint-initdb.d/database_scheme.sql"]