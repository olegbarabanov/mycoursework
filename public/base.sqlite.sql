BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "history" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT,
	"newdata"	TEXT,
	"date"	INTEGER DEFAULT (strftime('%s','now'))
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"name"	TEXT,
	"password"	TEXT,
	"email"	TEXT,
	"custom_info"	TEXT
);
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
	FOREIGN KEY("contract_type_id") REFERENCES "contract_types"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("client") REFERENCES "clients"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("act") REFERENCES "acts"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("user") REFERENCES "users"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("invoice") REFERENCES "invoices"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("stage") REFERENCES "contract_stages"("id") ON DELETE RESTRICT ON UPDATE CASCADE
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
	FOREIGN KEY("user_id") REFERENCES "users"("id") ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY("role_id") REFERENCES "roles"("id") ON DELETE RESTRICT ON UPDATE CASCADE
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
INSERT INTO "users" VALUES (16,'admin','$2y$10$n/Z3LvTiCW4.nhKUOMyIZ.cmbzK0o/0/jveJ18aMVocKLjg5o7czG','admin','zxczczxc');
INSERT INTO "contracts" VALUES (2,'2020-04-04','2020-04-11','null',1,'null',1,16,'null',2,'null','Договор на поддержку');
INSERT INTO "clients" VALUES (1,'ООО "Интернейшнл"','Петров Василий Степанович','г. Екатеринбург, ул. Космолетов 79','г. Екатеринбург, ул. Космонавтов 79','','+67567657','null','null');
INSERT INTO "clients" VALUES (2,'ООО Революшн23','Чапаев Василий Иванович','Крондштат','Москва',1917,'+723213232','test@mail.ru','null');
INSERT INTO "acts" VALUES (1,'2020-04-21','null');
INSERT INTO "contract_stages" VALUES (1,'Обсуждение');
INSERT INTO "contract_stages" VALUES (2,'Подписание');
INSERT INTO "contract_types" VALUES (1,'Договор на поддержку');
INSERT INTO "roles" VALUES (1,'Администратор');
COMMIT;
