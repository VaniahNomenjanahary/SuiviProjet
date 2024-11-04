/*Tena izy*/
Create table utilisateur(
    id serial primary key not null,
    nom varchar(80),
    prenom varchar(80),
    password varchar(80),
    mail varchar(90),
    datenaiss date,
    photo text,
    fonction varchar(50),
    role varchar(50),
    created_at date,
    updated_at date,
    token varchar(250)
);

Create table projet(
    id serial primary key not null,
    idutilisateur int,
    intitule varchar(250),
    descriptions varchar(255),
    datedebut date,
    datefin date,
    deleted_at date,
    updated_at date,
    created_at date,
    attente boolean
);

Alter table projet add foreign key (idutilisateur) REFERENCES utilisateur(id);



Create table taches(
    id serial primary key not null,
    idprojet int,
    tache varchar(200),
    datedebut date,
    datefin date,
    idstatut int,
    descriptions varchar(255),
    priorite int,
    created_at date,
    updated_at date,
    deleted_at date,
    attente boolean default false
);

alter table taches add column attente boolean default false;

Create table statuts(
    id serial primary key not null,
    statut varchar(80)
);

ALTER TABLE taches ADD FOREIGN KEY (idprojet) REFERENCES projet(id);
ALTER TABLE taches ADD FOREIGN KEY (idstatut) REFERENCES statuts(id);


Create table taches_user(
    user_id int,
    taches_id int,
    FOREIGN key (user_id) REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN key (taches_id) REFERENCES taches(id) ON DELETE CASCADE
);

Create table commentaire(
    id serial primary key not null,
    idtache int,
    idutilisateur int,
    contenu varchar(255),
    deleted_at date
);

ALTER TABLE commentaire ADD FOREIGN KEY (idtache) REFERENCES taches(id);
ALTER TABLE commentaire ADD FOREIGN KEY (idutilisateur) REFERENCES utilisateur(id);

Create table notifications(
    id serial primary key not null,
    contenu varchar(255)
);