import React, { useEffect, useState } from "react";
import {
  Page,
  View,
  Text,
  Document,
  PDFViewer,
  StyleSheet,
  PDFDownloadLink,
  Image,
  Font,
} from "@react-pdf/renderer";
import logo from "../../images/gpmci.png";

export default function (abonnement) {
  const [dateJour, setDateJour] = useState(new Date());

  useEffect(() => {
    const intervalId = setInterval(() => {
      setDateJour(new Date());
    }, 1000 * 60);

    return () => clearInterval(intervalId);
  }, []);

  const formatDate = (date) => {
    const options = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };
    return date.toLocaleDateString("fr-FR", options);
  };

  // PDF
  Font.register({
    family: "Oswald",
    src: "https://fonts.gstatic.com/s/oswald/v13/Y_TKV6o8WovbUd3m_X9aAA.ttf",
  });

  // Font.register({family: 'Times-Roman' })
  const styles = StyleSheet.create({
    body: { paddingTop: 35, paddingBottom: 65, paddingHorizontal: 35 },
    titre: {
      fontSize: 20,
      fontWeight: "bold",
      border: 1,
      paddingTop: 10,
      paddingBottom: 10,
      textAlign: "center",
      fontFamily: "Helvetica-Bold",
      marginTop: 20,
    },
    entete: { borderBottom: 2, borderBottomColor: "orange" },
    logo: { width: 150 },
    date: {
      display: "grid",
      textAlign: "left",
      marginLeft: 300,
      fontSize: 11,
      marginTop: 20,
      fontWeight: 700,
    },
    attention: {
      border: 1,
      marginTop: 15,
      marginLeft: 250,
      fontSize: 12,
      paddingTop: 10,
      paddingBottom: 10,
      paddingLeft: 7,
      paddingRight: 7,
    },
    compagnie: {
      textTransform: "uppercase",
      marginBottom: 5,
      fontFamily: "Helvetica",
    },
    label: { fontSize: 10, marginRight: 3 },
    representant: {
      fontWeight: "heavy",
      paddingLeft: 10,
      marginLeft: 10,
      fontFamily: "Times-BoldItalic",
    },
    reference: { fontSize: 13, marginBottom: 10, marginTop: 20 },
    representantValeur: { fontFamily: "Times-Bold" },
    tableau: { border: 1 },
    bgOrange: { backgroundColor: "darkorange", height: 15 },
    content: {
      paddingTop: 30,
      paddingBottom: 30,
      paddingLeft: 15,
      paddingRight: 15,
    },
    liste: { fontSize: 14 },
    discipline: {
      paddingLeft: 20,
      paddingTop: 7,
      fontStyle: "italic",
      fontSize: 12,
      fontFamily: "Helvetica-Oblique",
    },
    montantTotal: {
      marginTop: 30,
      marginBottom: 30,
      paddingLeft: 15,
      flexDirection: "row",
    },
    colonne2: { flexGrow: 1 },
    labelMontantTotal: {
      fontFamily: "Helvetica-Bold",
      fontSize: 13,
      border: 1,
    },
    valeurMontantTotal: {
      fontFamily: "Helvetica-Bold",
      fontSize: 13,
      textAlign: "right",
      paddingRight: 20,
      backgroundColor: "darkorange",
      paddingTop: 7,
      paddingBottom: 7,
      marginRight: 30,
      paddingLeft: 20,
    },
    sectionReglement: {
      fontFamily: "Times-Roman",
      marginTop: 25,
      fontSize: 12,
    },
    optionReglement: {
      color: "red",
      fontFamily: "Times-Italic",
      fontSize: 10,
      paddingTop: 5,
    },
    consigne: { fontFamily: "Times-Bold", marginTop: 15, fontSize: 10 },
    signature: {
      textAlign: "right",
      marginRight: 50,
      fontFamily: "Times-Bold",
      fontSize: 10,
      marginTop: 25,
    },
    piedPage: {
      fontFamily: "Times-Bold",
      fontSize: 9,
      color: "orange",
      bottom: 5,
      left: 30,
      right: 0,
      position: "absolute",
      borderTop: 2,
      borderColor: "orange",
      paddingTop: 7,
      width: 200,
    },
  });

  const Facture = () => (
    <Document>
      <Page size="A4" orientation="portrait" style={styles.body}>
        <View style={styles.entete}>
          <Image src={logo} style={styles.logo} />
        </View>
        <Text style={styles.titre}>
          PARTICIPATION AUX MINING OLYMPIADES 2024
        </Text>
        <Text style={styles.date}>Abidjan, le {formatDate(dateJour)}</Text>
        <View style={styles.attention}>
          {abonnement.abonnement.compagnie && (
            <div>
              <Text style={styles.compagnie}>
                {abonnement.abonnement.compagnie.titre}
              </Text>
              <Text>
                <Text style={styles.label}>Att:</Text>
                <Text style={styles.representant}>
                  {abonnement.abonnement.compagnie.representant}
                </Text>
              </Text>
            </div>
          )}
        </View>
        <Text style={styles.reference}>
          Facture N°:
          <Text style={styles.representantValeur}>
            {abonnement.abonnement.reference}
          </Text>
        </Text>
        <View style={styles.tableau}>
          <Text style={styles.bgOrange}></Text>
          <View style={styles.content}>
            <Text style={styles.liste}>Liste des disciplines choisies:</Text>
            {abonnement.abonnement.disciplines && (
              <div>
                {abonnement.abonnement.disciplines.map((discipline, index) => (
                  <Text key={index} style={styles.discipline}>
                    - {discipline.titre}{" "}
                  </Text>
                ))}
              </div>
            )}
          </View>
          <View style={styles.montantTotal}>
            <Text style={styles.colonne2}>
              <Text style={styles.labelMontantTotal}>
                Montant total de la partication :{" "}
              </Text>
            </Text>
            <Text style={styles.valeurMontantTotal}>
              {abonnement.abonnement.montant}
            </Text>
          </View>
          <Text style={styles.bgOrange} />
        </View>
        <View style={styles.sectionReglement}>
          <Text style={styles.labelReglement}>
            Vous pouvez effectuer votre règlement:
          </Text>
          <Text style={styles.optionReglement}>
            * par chèque à l'ordre de GPMCI ou Groupement Professionnel des
            Miniers de Côte d'Ivoire
          </Text>
          <Text style={styles.optionReglement}>
            * par virement bancaire : Groupement Professionnel des Miniers de
            Côte d'Ivoire (GPMCI) sur le compte N° CI059 01004 120070130001 72 à
            ECOBANK bd Latrille II Plateaux Vallons.
          </Text>
        </View>
        <Text style={styles.consigne}>
          Quel que soit votre mode de règlement, prière contacter le service
          comptabilité pour la remise du reçu de paiement.
        </Text>
        <Text style={styles.signature}>Le Trésorier Général</Text>
        <View style={styles.piedPage} fixed>
          <Text>Abidjan, Cocody Riviera 3 Bonoumin cité Zinsou</Text>
          <Text>Villa Mining House, 08 BP 2194 ABJ 08</Text>
          <Text>TEL. 27 22 409 366 / Cel : 07 87 755 337</Text>
          <Text>info@chambredesmines.org</Text>
        </View>
      </Page>
    </Document>
  );

  console.log("Dans le component Facture");
  console.log(abonnement);

  return (
    <div>
      <div className="annonce">
        <p>Félicitations vos participants ont été enregistrés avec succès!</p>
        <p>
          Voulez-vous choisir des disciplines supplémentaires ?{" "}
          <a href="/discipline-supplementaire/">Cliquez ici</a>
        </p>
        <p>
          {/*Merci de télécharger <a href="/facture/">votre facture</a>.*/}
          <PDFDownloadLink
            document={<Facture />}
            fileName={`facture-${abonnement.abonnement.reference}.pdf`}
          >
            {({ blob, url, loading, error }) =>
              loading
                ? "Chargement de la facture..."
                : "Merci de cliquer ici pour télécharger votre facture"
            }
          </PDFDownloadLink>
        </p>
      </div>
    </div>
  );
}
