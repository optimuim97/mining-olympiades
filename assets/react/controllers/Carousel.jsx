import React, { useEffect, useState } from "react";
import AOS from "aos";
import "aos/dist/aos.css";

export default function Carousel() {
  const [currentIndex, setCurrentIndex] = useState(0);

  const carouselItems = [
    {
      title: "SOYEZ PRÊT POUR L’OLYMPIADES DES MINES 2024",
      description: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
    },
    {
      title: "DÉCOUVREZ LES NOUVELLES OPPORTUNITÉS",
      description:
        "Proin eget tortor risus. Nulla quis lorem ut libero malesuada feugiat.",
    },
    {
      title: "PARTICIPEZ À DES COMPÉTITIONS EXCITANTES",
      description: "Vivamus suscipit tortor eget felis porttitor volutpat.",
    },
  ];

  useEffect(() => {
    AOS.init();

    const interval = setInterval(() => {
      setCurrentIndex((prevIndex) => (prevIndex + 1) % carouselItems.length);
    }, 4000);

    return () => clearInterval(interval);
  }, [carouselItems.length]);

  return (
    <>
      {/* Desktop */}
      <section
        className="d-none d-lg-block"
        id="carousel"
        style={{ padding: "100px 50px 0 50px", height: "650px" }}
      >
        <div
          className="carousel-container"
          style={{
            position: "relative",
            color: "white",
            textAlign: "left",
            padding: "50px 20px",
            maxWidth: "450px",
          }}
        >
          <div
            className="carousel"
            data-aos="zoom-in"
            style={{ position: "relative" }}
          >
            {carouselItems.map((item, index) => (
              <div
                key={index}
                className={`carousel-elt ${
                  index === currentIndex ? "active" : ""
                }`}
                style={{
                  opacity: index === currentIndex ? 1 : 0,
                  transition: "opacity 1s ease-in-out",
                  position: "absolute",
                  left: 0,
                  width: "100%",
                  padding: 0,
                }}
              >
                <h1
                  style={{
                    fontSize: "2rem",
                    marginBottom: "10px",
                    lineHeight: "1.2",
                    wordWrap: "break-word",
                  }}
                >
                  {item.title}
                </h1>
                {/* <p
                  style={{
                    fontSize: "1.25rem",
                    wordWrap: "break-word",
                    color: "#f69322",
                  }}
                >
                  {item.description}
                </p> */}
              </div>
            ))}
          </div>

          {/* Indicateurs de carrousel */}
          <div
            className="carousel-indicators"
            style={{
              position: "absolute",
              bottom: "20px",
              left: "0",
              display: "flex",
              alignItems: "center",
              justifyContent: "flex-start",
              paddingLeft: "20px",
              marginLeft: "0",
            }}
          >
            {carouselItems.map((_, index) => (
              <div
                key={index}
                onClick={() => setCurrentIndex(index)}
                aria-label={`Slide ${index + 1}`}
                style={{
                  width: currentIndex === index ? "50px" : "13px",
                  height: currentIndex === index ? "13px" : "13px",
                  backgroundColor: "#f69322",
                  marginRight: "10px",
                  cursor: "pointer",
                  borderRadius: currentIndex === index ? "5px" : "100px",
                  transition: "width 0.3s ease, background-color 0.3s ease",
                }}
              />
            ))}
          </div>
        </div>
      </section>
      {/* Desktop */}

      {/* Mobile */}
      <section
        className="d-block d-lg-none"
        id="carousel"
        style={{ padding: "0 0", height: "70vh" }}
      >
        <div
          className="carousel-container"
          style={{
            position: "relative",
            color: "white",
            textAlign: "left",
            padding: "100px 20px",
            maxWidth: "500px",
            height: "100%",
          }}
        >
          <div
            className="carousel"
            data-aos="zoom-in"
            style={{
              position: "relative",
              marginTop: "20px",
              marginBottom: "30px",
            }}
          >
            {carouselItems.map((item, index) => (
              <div
                key={index}
                className={`carousel-elt ${
                  index === currentIndex ? "active" : ""
                }`}
                style={{
                  opacity: index === currentIndex ? 1 : 0,
                  transition: "opacity 1s ease-in-out",
                  position: "absolute",
                  left: 0,
                  width: "100%",
                  padding: 0,
                }}
              >
                <h1
                  style={{
                    fontSize: "2rem",
                    marginBottom: "10px",
                    lineHeight: "1.2",
                    wordWrap: "break-word",
                  }}
                >
                  {item.title}
                </h1>
                <p
                  style={{
                    fontSize: "1rem",
                    wordWrap: "break-word",
                    color: "#f69322",
                  }}
                >
                  {item.description}
                </p>
              </div>
            ))}
          </div>

          {/* Indicateurs de carrousel */}
          <div
            className="carousel-indicators"
            style={{
              maxWidth: "500px",
            }}
          >
            {carouselItems.map((_, index) => (
              <div
                key={index}
                onClick={() => setCurrentIndex(index)}
                aria-label={`Slide ${index + 1}`}
                style={{
                  width: currentIndex === index ? "50px" : "13px",
                  height: currentIndex === index ? "13px" : "13px",
                  backgroundColor: "#f69322",
                  marginRight: "10px",
                  cursor: "pointer",
                  borderRadius: currentIndex === index ? "5px" : "100px",
                  transition: "width 0.3s ease, background-color 0.3s ease",
                }}
              />
            ))}
          </div>
        </div>
      </section>
      {/* Mobile */}
    </>
  );
}
