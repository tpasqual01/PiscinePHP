SELECT titre, resum FROM film WHERE titre REGEXP '42' OR resum REGEXP '42' ORDER BY duree_min ASC;
