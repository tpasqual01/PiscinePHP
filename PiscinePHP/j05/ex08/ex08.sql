SELECT nom, prenom, DATE(date_naissance) FROM fiche_personne WHERE LEFT(date_naissance, 4) = 1932 ORDER BY nom ASC;
