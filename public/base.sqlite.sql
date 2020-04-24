BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "contracts" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"reg_date"	INTEGER,
	"end_date"	TEXT,
	"custom_info"	TEXT,
	"contract_type_id"	INTEGER,
	"tech_spec"	BLOB,
	"client"	INTEGER,
	"user"	INTEGER,
	"act"	INTEGER,
	"stage"	INTEGER,
	"invoice"	INTEGER,
	"name"	TEXT,
	FOREIGN KEY("contract_type_id") REFERENCES "contract_types"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("client") REFERENCES "clients"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("act") REFERENCES "acts"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("user") REFERENCES "users"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("invoice") REFERENCES "invoices"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("stage") REFERENCES "contract_stages"("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS "clients" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT,
	"person"	TEXT,
	"legal_address"	TEXT,
	"physical_address"	TEXT,
	"reg_date"	INTEGER,
	"phone"	TEXT,
	"email"	TEXT,
	"custom_info"	TEXT
);
CREATE TABLE IF NOT EXISTS "users2roles" (
	"user_id"	INTEGER,
	"role_id"	INTEGER,
	FOREIGN KEY("user_id") REFERENCES "users"("id") ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY("role_id") REFERENCES "roles"("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT,
	"password"	TEXT,
	"email"	TEXT,
	"custom_info"	TEXT
);
CREATE TABLE IF NOT EXISTS "invoices" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"reg_date"	INTEGER,
	"file"	BLOB
);
CREATE TABLE IF NOT EXISTS "logs" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"text"	TEXT,
	"date"	INTEGER
);
CREATE TABLE IF NOT EXISTS "acts" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"reg_date"	INTEGER,
	"file"	BLOB
);
CREATE TABLE IF NOT EXISTS "contract_stages" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT
);
CREATE TABLE IF NOT EXISTS "contract_types" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT UNIQUE
);
CREATE TABLE IF NOT EXISTS "roles" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT NOT NULL UNIQUE
);
INSERT INTO "contracts" VALUES (1,'null','null','null',1,'null',2,1,'null',1,'null','Очень важный договор');
INSERT INTO "clients" VALUES (1,'ООО "Интернейшнл"','Петров Василий Степанович','г. Екатеринбург, ул. Космолетов 79','г. Екатеринбург, ул. Космонавтов 79','','+67567657','null','null');
INSERT INTO "clients" VALUES (2,'ООО Революшн','Чапаев Василий Иванович','Крондштат','Москва',1917,'+723213232','null','null');
INSERT INTO "clients" VALUES (3,'9876','null','null','null','null','null','null','null');
INSERT INTO "clients" VALUES (6,'ewrefwfsdfsdf','null','null','null','null','null','null','null');
INSERT INTO "clients" VALUES (7,'null','null','null','null','null','null','null','null');
INSERT INTO "clients" VALUES (8,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO "clients" VALUES (9,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO "clients" VALUES (10,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO "users" VALUES (0,'sfd','sdfs','sdfs','sdfsdf');
INSERT INTO "users" VALUES (1,'scdasdadsasfd','sdfs','sdfs','sdfsdf');
INSERT INTO "users" VALUES (2,'sfd','sdfs','sdfs','sdfsdf');
INSERT INTO "users" VALUES (3,'sfd','sdfs','sdfsdasdasdasd','sdfsdf');
INSERT INTO "users" VALUES (4,'sfd','sdfs','sdfsыфвфывфвsadsaddsdad','sdfsdf');
INSERT INTO "users" VALUES (5,'asdsadadssadasdasd','asdsa','sadassadsad','sadasdaasdsadasdas');
INSERT INTO "users" VALUES (6,'sdf','sdf','null','null');
INSERT INTO "users" VALUES (7,'asdsadasdsadasd','sadsa','sada','sad');
INSERT INTO "users" VALUES (8,'asd','asd','asd','asdas');
INSERT INTO "users" VALUES (9,'null','null','null','null');
INSERT INTO "users" VALUES (10,'null','null','null','null');
INSERT INTO "users" VALUES (11,'asdasda','sadasdas','null','null');
INSERT INTO "users" VALUES (12,'null','null','null','null');
INSERT INTO "users" VALUES (13,'null','null','null','null');
INSERT INTO "users" VALUES (14,'null','null','null','null');
INSERT INTO "users" VALUES (15,'asdas','sad','asdasd','asd');
INSERT INTO "contract_stages" VALUES (1,'Обсуждение');
INSERT INTO "contract_types" VALUES (1,'Договор на поддержку');
INSERT INTO "roles" VALUES (1,'Администратор');
COMMIT;
