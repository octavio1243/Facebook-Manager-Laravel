import mysql.connector #pip3 install mysql-connector

conexion = mysql.connector.connect(
    host = "localhost",
    user = "root",
    password = "",
    db='sistemaautopost'
)

cur = conexion.cursor()


sentencias=[

#Tabla roles
"INSERT INTO `rols` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Cliente');",
"INSERT INTO `rols` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Administrador');",

#Tabla paymentMethod
"INSERT INTO `payment_methods` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Paypal');",
"INSERT INTO `payment_methods` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Bitso');",
"INSERT INTO `payment_methods` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Airtm');",
"INSERT INTO `payment_methods` (`id`, `created_at`, `name`) VALUES (NULL, current_timestamp(), 'Transferencia bancaria');",

#Tabla status
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Pausado', 'StatusPost');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Corriendo', 'StatusPost');",

"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Habilitado', 'StatusPostGroup');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Deshabilitado', 'StatusPostGroup');",

"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Posteado', 'StatusRecordPost');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Pendiente', 'StatusRecordPost');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Error', 'StatusRecordPost');",

"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Baneado', 'StatusUser');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Vigente', 'StatusUser');",

"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Logueado', 'StatusFacebookAccount');",
"INSERT INTO `statuses` (`id`, `created_at`, `name`, `type`) VALUES (NULL, current_timestamp(), 'Deslogueado', 'StatusFacebookAccount');",

]
for sentencia in sentencias:
    cur.execute(sentencia)
    
conexion.commit()
cur.close()