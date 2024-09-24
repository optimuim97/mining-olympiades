import React, { useEffect, useState } from "react";
import AOS from "aos";
import styled from "styled-components";

const ResponsiveContainer = styled.div`
  padding: 0 20px;
  max-width: 1300px;
  margin: 0 auto;

  @media (min-width: 768px) {
    padding: 0 50px;
  }
`;

const PresentationSection = styled.section`
  position: relative;
  overflow: hidden;
  background-color: #f8f4ec;
  margin-top: 50px;
  border-radius: 20px;

  @media (min-width: 768px) {
    margin-top: 100px;
  }
`;

const BackgroundOverlay = styled.div`
  background-image: linear-gradient(to bottom, #ffdebb, rgba(255, 140, 0, 0.4)),
    url(/assets/images/${(props) => props.imgSrc});
  background-size: cover;
  background-position: center;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;

  @media (min-width: 768px) {
    background-image: linear-gradient(to right, #ffdebb, rgba(255, 140, 0, 0.2)),
      url(/assets/images/${(props) => props.imgSrc});
  }
`;

const ContentWrapper = styled.div`
  position: relative;
  z-index: 2;
  padding: 30px;
  max-width: 100%;

  @media (min-width: 768px) {
    padding: 50px;
    max-width: 550px;
  }
`;

const Title = styled.h4`
  font-weight: bold;
  font-size: 1.5rem;
  line-height: 1.2;

  @media (min-width: 768px) {
    font-size: 2rem;
  }
`;

const Subtitle = styled.h3`
  color: #018b4c;
  font-weight: bold;
  font-size: 1.5rem;
  margin-bottom: 15px;

  @media (min-width: 768px) {
    font-size: 2rem;
  }
`;

const Content = styled.div`
  font-size: 0.8rem;
  line-height: 1.5;
  text-align: justify;
  font-weight: 500;

  @media (min-width: 768px) {
    font-size: 1.15rem;
  }
`;

const ReadMoreButton = styled.button`
  background-color: #f69322;
  color: #fff;
  border: none;
  border-radius: 100px;
  padding: 10px 20px;
  margin-top: 10px;
  cursor: pointer;
  display: flex;
  align-items: center;
  font-size: 0.9rem;

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

const IllustrationSection = styled.section`
  margin-top: 50px;

  @media (min-width: 768px) {
    margin-top: 100px;
  }
`;

const ResponsiveImage = styled.img`
  width: 100%;
  height: auto;
  max-width: 100%;
  display: block;
  margin: 0 auto;
`;

export default function PresentationComponent() {
  const [data, setData] = useState({});
  const [trimmedContent, setTrimmedContent] = useState("");

  useEffect(() => {
    AOS.init({ duration: 1500 });

    async function fetchData() {
      try {
        const response = await fetch("/api/presentation/");
        if (!response.ok) {
          throw new Error("Réponse non valide depuis le serveur");
        }
        const data = await response.json();
        setData(data);

        const maxCharacters = 500;
        let truncatedContent = data.contenu.slice(0, maxCharacters);
        if (data.contenu.length > maxCharacters) {
          truncatedContent += "...";
        }
        setTrimmedContent(truncatedContent);
      } catch (e) {
        console.error("Erreur de la récupération des données: ", e);
      }
    }

    fetchData();
  }, []);

  const img_sportifs = "sportifs.png";
  const img_olymapiade = "OLYMAPIADE.png";

  return (
    <ResponsiveContainer>
      <PresentationSection>
        <BackgroundOverlay imgSrc={img_olymapiade} />
        <ContentWrapper>
          <Title>Présentation</Title>
          <Subtitle>Les Mining Olympiades</Subtitle>
          <Content dangerouslySetInnerHTML={{ __html: trimmedContent }} />
          {data.contenu && data.contenu.length > 500 && (
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
          )}
        </ContentWrapper>
      </PresentationSection>

      <IllustrationSection>
        <div
          className="illustration justify-content-center"
          data-aos="zoom-in"
          data-aos-duration="3000"
          data-aos-delay="100"
        >
          <ResponsiveImage
            src={`/assets/images/${img_sportifs}`}
            alt="Les sportifs"
          />
        </div>
      </IllustrationSection>
    </ResponsiveContainer>
  );
}
