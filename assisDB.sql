
drop database if exists AssistenzaOnline;

create database AssistenzaOnline;

use AssistenzaOnline;


create table Adminn(
    CFa char(16) not null,
    password char(64)not null,
    pswAd char(64)not null,

    nome varchar(20) not null,
    cognome varchar(20) not null,

    dataNascita date,
    email varchar(20)not null unique,
    genere enum("F", "M", "A") not null, 
    tel char(10),

    primary key(CFa)

)engine=innoDB;


insert into Adminn values
    ("aaaa000011112222", sha2("a", 256), sha2("adminpsw", 256), "admin 1", "cognome", null, "aaaa@gmail.com", "M", null),
    ("bbbb000011112222", sha2("b", 256), sha2("adminpsw", 256), "admin 2", "cognome", null, "bbbb@gmail.com", "M", null),
    ("cccc000011112222", sha2("c", 256), sha2("adminpsw", 256), "admin 3", "cognome", null, "cccc@gmail.com", "M", null);


create table Faq(
    CFa char(16) not null,
    codFaq smallInt(5)auto_increment not null,
    problema varchar(300) not null unique,
    tipo enum("hardware", "sofware"),

    primary key(codFaq),

    foreign key(CFa) references Adminn(CFa)
)engine=innoDB;

insert into Faq values
    ("bbbb000011112222", null, "come distinguere hardware e software?", null),
    ("aaaa000011112222", null, "il monitor non si accende", "hardware"),
    ("bbbb000011112222", null, "il mouse non si muove", "hardware");
     




create table Soluzioni(
    codSoluzione smallInt(5)auto_increment not null,
    soluzione varchar(280) not null unique,

    primary key(codSoluzione)
)engine=innoDB;

insert into Soluzioni values

    (null, "controllare se è correttamente alimentato"),
  
    (null, "se è a batterie, controllare che siano cariche"),
    (null, "è collegato?"),
    (null, "controllare se è acceso"),
    (null, "l'hardware è quella parte del computer che si può prendere a calci"),
    (null, "il software è quella parte contro cui si può solo imprecare");

create table ha( 
    codFaq smallInt(5) not null,
    codSoluzione smallInt(5) not null,

    primary key(codFaq, codSoluzione),
    foreign key(codFaq) references Faq (codFaq),
    foreign key(codSoluzione) references Soluzioni (codSoluzione)
    
)engine=innoDB;

insert into ha values 
    (2, 1),
    (3, 2),
    (3, 3),
    (2, 4),
    (1, 5),
    (1, 6);


create table Interventi(
   
    codInte smallInt(5)auto_increment not null,
    metodo enum("tipo 1", "tipo 2", "tipo 3")not null,
    costo float not null,

    primary key(codInte)

)engine=innoDB;

insert into Interventi values 
    (null, "tipo 1", 8.27 ),
    (null, "tipo 2", 15.70 ),
    (null, "tipo 3", 27.12 );



create table Utenti(
    CFu char(16) not null,
    password char(64)not null,
    nome varchar(20) not null,
    cognome varchar(20) not null,
    dataNascita date,
    email varchar(30)unique not null,
    tel char(10),

    pIVA char(11), 
    genere enum("F", "M", "A") not null, 

   /* numCarta char(16) ,
    cvv char(3),
    dataScadenza date ,*/

    check (dataNascita<now()),

    primary key (CFu)

)engine=innoDB;

insert into Utenti values
    ("eeee000011112222", sha2("1234", 256), "elliot", "alderson", '1983-08-27', "mrRobot@gmail.com", null, null, "M"),
    ("CGTGLI01C48H856P", sha2("1234", 256), "giulia", "cogotti", '2001-03-08', "giulicogotti@gmail.com", null, null, "F");


create table Assistenza(
    CFu char(16) not null,
    codInte smallInt(5) not null,
    CFa char(16),

    codProblema smallInt(5)auto_increment not null,


    lvlUrgenza enum("alto", "medio", "basso")not null,
    tipo enum("hardware", "software"),
    descri varchar(300)not null,
    risolto boolean not null default 0,
    rifiutato boolean not null default 0,

    primary key (codProblema),

    foreign key (CFu) references Utenti (CFu),
    foreign key (CFa) references Adminn (CFa),
    foreign key (codInte) references Interventi (codInte)

)engine=innoDB;


insert into Assistenza values
    ("eeee000011112222", 1, null, null, "basso", "software", "i tasti non corrispondono con il testo", 0, 0),
    ("CGTGLI01C48H856P", 1, null, null, "alto", "hardware", "la ventola fa un rumore strano", 0, 0),
    ("CGTGLI01C48H856P", 2, null, null, "medio", "software", "non si accende il monitor", 0, 0);
    




create table chat(
    codProblema smallInt(5) not null,
    idChat smallInt(7)auto_increment not null,
   
    tx varchar(20)not null, 
    msg varchar(500) not null,
    orario time not null,
    dataa date not null,
    
    primary key(idChat),

    foreign key (codProblema) references Assistenza (codProblema)


)engine=innoDB;



