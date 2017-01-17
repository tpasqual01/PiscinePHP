SELECT titre AS "Titre", resum AS "Resume", LEFT(annee_prod, 4) FROM film, genre WHERE film.id_genre=genre.id_genre AND genre.nom = 'erotic';
