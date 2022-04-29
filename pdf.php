<?php
session_start();
$nom=$_COOKIE["nom"];
$prix = $_COOKIE["prix"];
$image = $_COOKIE["image"];
// Connexion à la BDD (à personnaliser)
$link = mysqli_connect('localhost:3307','root','','projet_db');
// Si base de données en UTF-8, il faudra utiliser la fonction utf8_decode() pour tous les champs de texte à afficher

// extraction des données à afficher dans le sous-titre (nom du voyageur et dates de son voyage)
$requete = "SELECT * FROM produits WHERE nom='$nom'";
$result = mysqli_query($link, $requete);
// tableau des résultats de la ligne > $data_voyageur['nom_champ']
$data_voyageur = mysqli_fetch_array($result);
mysqli_free_result($result);

// Appel de la librairie FPDF
require("fpdf/fpdf.php");
// Création de la class PDF
class PDF extends FPDF {
    // Header
    function Header() {
      // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
     
      $this->Image('images\R.jpg',4,2,80);
      // Saut de ligne 20 mm
      $this->Ln(20);
  
      // Titre gras (B) police Helbetica de 11
      $this->SetFont('Helvetica','B',11);
      // fond de couleur gris (valeurs en RGB)
      $this->setFillColor(230,230,230);
       // position du coin supérieur gauche par rapport à la marge gauche (mm)
      $this->SetX(70);
      // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
      $this->Cell(60,8,'E-SPORTS',0,1,'C',1);
      // Saut de ligne 10 mm
      $this->Ln(10);    
    }
    // Footer
    function Footer() {
      // Positionnement à 1,5 cm du bas
      $this->SetY(-15);
      // Police Arial italique 8
      $this->SetFont('Helvetica','I',9);
      // Numéro de page, centré (C)
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
  }
  // On active la classe une fois pour toutes les pages suivantes
// Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
$pdf = new PDF('P','mm','A4');

// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
// Polices par défaut : Helvetica taille 9
$pdf->SetFont('Helvetica','',9);
// Couleur par défaut : noir
$pdf->SetTextColor(0);
// Compteur de pages {nb}
$pdf->AliasNbPages();
// Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
$pdf->SetFont('Helvetica','B',11);
// couleur de fond de la cellule : gris clair
$pdf->setFillColor(230,230,230);
// Cellule avec les données du sous-titre sur 2 lignes, pas de bordure mais couleur de fond grise        
$pdf->Ln(10); // saut de ligne 10mm
// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
function entete_table($position_entete) {
    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond RVB
    $pdf->SetFillColor(221); // Couleur des filets RVB
    $pdf->SetTextColor(0); // Couleur du texte noir
    $pdf->SetY($position_entete);
    // position de colonne 1 (10mm à gauche)  
    $pdf->SetX(10);
    $pdf->Cell(60,8,'id',1,0,'C',1);  // 60 >largeur colonne, 8 >hauteur colonne
    // position de la colonne 2 (70 = 10+60)
    $pdf->SetX(70); 
    $pdf->Cell(60,8,'Nom',1,0,'C',1);
    // position de la colonne 3 (130 = 70+60)
    $pdf->SetX(130); 
    $pdf->Cell(30,8,'Prix',1,0,'C',1);
  
    $pdf->Ln(); // Retour à la ligne
  }
  // AFFICHAGE EN-TÊTE DU TABLEAU
  // Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
  $position_entete = 70;
  // police des caractères
  $pdf->SetFont('Helvetica','',9);
  $pdf->SetTextColor(0);
  // on affiche les en-têtes du tableau
  entete_table($position_entete);
  $position_detail = 78; // Position ordonnée = $position_entete+hauteur de la cellule d'en-tête (60+8)
$requete2 = "SELECT * FROM produits WHERE nom='$nom'";
$result2 = mysqli_query($link, $requete2);
while ($data_visit = mysqli_fetch_array($result2)) {
  // position abcisse de la colonne 1 (10mm du bord)
  $pdf->SetY($position_detail);
  $pdf->SetX(10);
  $pdf->MultiCell(60,8,utf8_decode($data_visit['id']),1,'C');
    // position abcisse de la colonne 2 (70 = 10 + 60)  
  $pdf->SetY($position_detail);
  $pdf->SetX(70); 
  $pdf->MultiCell(60,8,utf8_decode($data_visit['nom']),1,'C');
  // position abcisse de la colonne 3 (130 = 70+ 60)
  $pdf->SetY($position_detail);
  $pdf->SetX(130); 
  $pdf->MultiCell(30,8,$data_visit['prix'].'dh',1,'C');

  // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
  $position_detail += 8; 
}
mysqli_free_result($result2);

 // affichage à l'écran...
 $pdf->Output('test.pdf','I');