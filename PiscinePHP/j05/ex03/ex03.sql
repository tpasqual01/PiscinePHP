INSERT INTO ft_table (login, groupe, date_de_creation) SELECT LEFT(nom, 8), 'other' ,DATE(date_naissance) FROM fiche_personne WHERE nom LIKE '%a%' AND LENGTH(id_perso < 9)  ORDER BY nom LIMIT 10;
