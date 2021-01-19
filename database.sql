DROP DATABASE IF EXISTS apiproyecto;
CREATE DATABASE apiproyecto;
USE apiproyecto;

CREATE TABLE rol(
    rol_id int(255) auto_increment PRIMARY KEY not null,
    name varchar(255) not null,
    description longtext not null,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL
);

CREATE TABLE users(
    user_id int(255) auto_increment PRIMARY KEY not null,
    first_name varchar(255) not null,
    dpi int(255) not null,
    address	varchar(255) not null,
    email	varchar(255) not null,
    birth_date varchar(255),
    telephone varchar(255),
    password varchar(255),
    rol_id int(255),
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    remember_token varchar(255),
    second_name varchar(255),
    FOREIGN KEY (rol_id) REFERENCES rol(rol_id)
);

CREATE TABLE question(
    question_id int(255) auto_increment PRIMARY KEY not null,
    subject varchar(255) NOT NULL,
    message longtext NOT NULL,
    email varchar(255) NOT NULL,
    telephone varchar(255),
    user_id int(255) NOT NULL,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE response(
    response_id int(255) auto_increment PRIMARY KEY NOT NULL,
    subject varchar(255) NOT NULL,
    message longtext NOT NULL,
    file varchar(255),
    question_id int(255) NOT NULL,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    FOREIGN kEY (question_id) REFERENCES question(question_id)
);

CREATE TABLE module(
    module_id int(255) auto_increment PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    description longtext,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL
);

CREATE TABLE user_module(
    person_module_id int(255) auto_increment PRIMARY KEY NOT NULL,
    description longtext,
    module_id int(255) NOT NULL,
    user_id int(255) NOT NULL,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    FOREIGN KEY (module_id) REFERENCES module(module_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE sector(
    sector_id int(255) auto_increment PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    description longtext,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL
);

CREATE TABLE local(
    local_id int(255) auto_increment PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    description longtext NOT NULL,
    status int(255),
    sector_id int(255) NOT NULL,
    inquilino_id int(255) NOT NULL,
    propietario_id int(255) NOT NULL,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    FOREIGN KEY (sector_id) REFERENCES sector(sector_id),
    FOREIGN KEY (inquilino_id) REFERENCES users(user_id),
    FOREIGN KEY (propietario_id) REFERENCES users(user_id)
);

CREATE TABLE service(
    service_id INT(255) auto_increment PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    description longtext NOT NULL,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL
);

CREATE TABLE local_service(
    local_service_id INT(255) auto_increment PRIMARY KEY NOT NULL,
    payment decimal(19,4) not null,
    file varchar(255),
    status int(255),
    month varchar(255),
    local_id int(255) not null,
    service_id int(255) not null,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    FOREIGN KEY (local_id) REFERENCES local(local_id),
    FOREIGN KEY (service_id) REFERENCES service(service_id)
);

CREATE TABLE card_type(
    card_type_id int(255) auto_increment PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    description longtext NOT NULL,
    status int(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL
);

CREATE TABLE payment_service(
    payment_service_id int(255) auto_increment PRIMARY KEY NOT NULL,
    card_number int(255) not null,
    expiration varchar(255) not null,
    postal_code varchar(255) not null,
    local_service_id INT(255) not null,
    card_type_id int(255) not null,
    FOREIGN KEY (local_service_id) REFERENCES local_service(local_service_id),
    FOREIGN KEY (card_type_id) REFERENCES card_type(card_type_id)
);

