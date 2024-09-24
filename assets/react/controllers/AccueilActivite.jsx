import React, { useEffect, useState } from "react";
import styled from "styled-components";

const ReadMoreButton = styled.button`
  background-color: #1f884e;
  color: #fff;
  border: none;
  border-radius: 100px;
  padding: 10px 20px;
  margin-top: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  width: 9rem;

  @media (min-width: 768px) {
    font-size: 1rem;
  }

  span {
    background-color: #fff;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-left: 10px;
    color: #f69322;
  }
`;

export default function () {
  const [activites, setActivites] = useState([]);

  const events = [
    {
      title: "Journée scientifique",
      description:
        "Organisée en marge du traditionnel weekend de la Sainte Barbe (la fête mondiale des Mineurs), les Mining Olympiades...",
      img: "OLYMAPIADE.png",
      bgColor: "#f68b2b",
      textColor: "#fff",
    },
    {
      title: "Journée sportive",
      description:
        "Organisée en marge du traditionnel weekend de la Sainte Barbe (la fête mondiale des Mineurs), les Mining Olympiades...",
      img: "OLYMAPIADE.png",
      bgColor: "#f1f2f640",
      textColor: "#000",
    },
    {
      title: "Soirée de récompense",
      description:
        "Organisée en marge du traditionnel weekend de la Sainte Barbe (la fête mondiale des Mineurs), les Mining Olympiades...",
      img: "OLYMAPIADE.png",
      bgColor: "#f68b2b",
      textColor: "#fff",
    },
  ];

  useEffect(() => {
    async function fetchActivites() {
      try {
        const response = await fetch("/api/activite/accueil");
        if (!response.ok) {
          throw new Error("La réquête a échoué");
        }
        const data = await response.json();
        setActivites(data);
      } catch (e) {
        console.error("Erreur de la récupération des activités:", e);
      }
    }

    fetchActivites();
  }, []);

  return (
    <div>
      {/* Desktop */}
      <div className="d-none d-lg-block">
        <section
          style={{
            display: "flex",
            justifyContent: "center",
            marginTop: "100px",
            padding: "0 50px",
          }}
        >
          {events.map((event, index) => (
            <div
              key={index}
              style={{
                backgroundColor: event.bgColor,
                margin: "10px",
                borderTopLeftRadius: "20px",
                borderTopRightRadius: "20px",
                width: "400px",
                boxShadow: "0px 2px 10px rgba(0, 0, 0, 0.1)",
              }}
            >
              {/* Image en haut */}
              <div
                style={{
                  borderTopLeftRadius: "20px",
                  borderTopRightRadius: "20px",
                  height: "17rem",
                  backgroundImage: `url(/assets/images/${event.img})`,
                  backgroundSize: "cover",
                  backgroundPosition: "center",
                }}
              />

              {/* Titre et description */}
              <div
                style={{
                  padding: "10px 35px",
                  height: "17rem",
                  display: "flex",
                  flexDirection: "column",
                  justifyContent: "center",
                }}
              >
                <h3
                  style={{
                    color: "#333",
                    margin: "1.05rem 0",
                    fontSize: "1.5rem",
                    fontWeight: "600",
                  }}
                >
                  {event.title}
                </h3>
                <p
                  style={{
                    color: event.textColor,
                    fontSize: "0.875rem",
                    lineHeight: "1.5",
                    textAlign: "justify",
                  }}
                >
                  {event.description}
                </p>

                {/* Bouton Lire plus */}
                <ReadMoreButton>
                  Lire plus{" "}
                  <span>
                    <svg
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      style={{ width: "60%" }}
                    >
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g
                        id="SVGRepo_tracerCarrier"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></g>
                      <g id="SVGRepo_iconCarrier">
                        <path
                          d="M14.7055 18.9112C14.2784 18.7306 14 18.3052 14 17.8333V15H3C2.44772 15 2 14.5523 2 14V10C2 9.44772 2.44772 9 3 9H14V6.1667C14 5.69483 14.2784 5.26942 14.7055 5.08884C15.1326 4.90826 15.6241 5.00808 15.951 5.34174L21.6653 11.175C22.1116 11.6307 22.1116 12.3693 21.6653 12.825L15.951 18.6583C15.6241 18.9919 15.1326 19.0917 14.7055 18.9112Z"
                          fill="#1f884e"
                        ></path>
                      </g>
                    </svg>
                  </span>
                </ReadMoreButton>
              </div>
            </div>
          ))}
        </section>
      </div>

      {/* Mobile */}
      <div className="d-block d-lg-none">
        <section
          style={{
            display: "flex",
            justifyContent: "center",
            flexDirection: "column",
            alignItems: "center",
            marginTop: "100px",
            padding: "0 20px",
          }}
        >
          {events.map((event, index) => (
            <div
              key={index}
              style={{
                backgroundColor: event.bgColor,
                margin: "10px",
                borderTopLeftRadius: "4rem",
                borderTopRightRadius: "4rem",
                width: "100%",
                boxShadow: "0px 2px 10px rgba(0, 0, 0, 0.1)",
              }}
            >
              {/* Image en haut */}
              <div
                style={{
                  borderTopLeftRadius: "4rem",
                  borderTopRightRadius: "4rem",
                  height: "17rem",
                  backgroundImage: `url(/assets/images/${event.img})`,
                  backgroundSize: "cover",
                  backgroundPosition: "center",
                }}
              />

              {/* Titre et description */}
              <div
                style={{
                  padding: "15px",
                  display: "flex",
                  height: "17rem",
                  flexDirection: "column",
                  justifyContent: "center",
                }}
              >
                <h3
                  style={{
                    color: "#333",
                    marginBottom: "10px",
                    fontSize: "1.25rem",
                    fontWeight: "600",
                  }}
                >
                  {event.title}
                </h3>
                <p
                  style={{
                    color: event.textColor,
                    fontSize: "0.875rem",
                    lineHeight: "1.5",
                    textAlign: "justify",
                  }}
                >
                  {event.description}
                </p>

                {/* Bouton Lire plus */}
                <ReadMoreButton>
                  Lire plus{" "}
                  <span>
                    <svg
                      viewBox="0 0 24 24"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      style={{ width: "60%" }}
                    >
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g
                        id="SVGRepo_tracerCarrier"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      ></g>
                      <g id="SVGRepo_iconCarrier">
                        <path
                          d="M14.7055 18.9112C14.2784 18.7306 14 18.3052 14 17.8333V15H3C2.44772 15 2 14.5523 2 14V10C2 9.44772 2.44772 9 3 9H14V6.1667C14 5.69483 14.2784 5.26942 14.7055 5.08884C15.1326 4.90826 15.6241 5.00808 15.951 5.34174L21.6653 11.175C22.1116 11.6307 22.1116 12.3693 21.6653 12.825L15.951 18.6583C15.6241 18.9919 15.1326 19.0917 14.7055 18.9112Z"
                          fill="#1f884e"
                        ></path>
                      </g>
                    </svg>
                  </span>
                </ReadMoreButton>
              </div>
            </div>
          ))}
        </section>
      </div>

      {/* <section id="activite">
                <div className="card-group activite">
                    {activites.map((activite, index) => (
                        <div
                            className={index % 2 === 0 ? "card vert" : "card gris"}
                            key={index}
                            data-aos="fade-left"
                            data-aos-duration="3000"
                            data-aos-delay="100"
                        >
                            <div className="card-body">
                                <div className="text-center">
                                    <img src={`/assets/images/icon/${activite.icon}`} alt={activite.titre} className="icon" />
                                </div>
                                <h5 className="card-title">
                                    <a href="/programme/" dangerouslySetInnerHTML={{ __html: activite.titre }}></a>
                                </h5>
                                <p
                                    className="card-text"
                                    style={{ textAlign: "justify" }}
                                    dangerouslySetInnerHTML={{ __html: activite.resume }}
                                >
                                </p>
                            </div>
                        </div>
                    ))}

                </div>
            </section> */}
    </div>
  );
}
