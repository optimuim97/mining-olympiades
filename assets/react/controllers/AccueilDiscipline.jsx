import React from "react";

import styled from "styled-components";

const ResponsiveContainer = styled.div`
  width: 100vw;
  overflow: hidden;
  padding: 0 20px;

  @media (min-width: 768px) {
    padding: 0 50px;
  }
`;

export default function () {
  return (
    <ResponsiveContainer>
      <section id="discipline">
        <div className="disciplines">
          <div
            data-aos="fade-down"
            data-aos-duration="3000"
            data-aos-delay="100"
          >
            {/*<h3 className="rubrique"><span>--</span> Compétitions <span>--</span></h3>*/}
            <h1 className="titre">Les disciplines </h1>
          </div>

          <div className="row mt-5">
            <div
              className="col-12 col-lg-4"
              data-aos="flip-left"
              data-aos-duration="3000"
              data-aos-delay="100"
            >
              <div className="row gap-2">
                <div className="col-8 ligne">Maracana zone</div>
                <div className="col-3 ligne">Golf</div>
                <div className="col-5 ligne">Babyfoot</div>
                <div className="col-6 ligne">4x4 relai</div>
                <div className="col-6 ligne">Pétanque</div>
                <div className="col-5 ligne">Basketball</div>
                <div className="col-4 ligne">Scrabble</div>
                <div className="col-7 ligne">Tennis de table</div>
                <div className="col-7 ligne">Jeu vidéo (Football ~ Ps4)</div>
                <div className="col-4 ligne">Natation</div>
              </div>
            </div>
            <div
              className="col-12 col-lg-4 mt-5 mt-lg-0"
              data-aos="zoom-out"
              data-aos-duration="3000"
              data-aos-delay="100"
            >
              <img
                src="/assets/images/sport.png"
                alt=""
                className="img-fluid"
              />
            </div>
            <div
              className="col-12 col-lg-4 mt-5 mt-lg-0"
              data-aos="flip-right"
              data-aos-duration="3000"
              data-aos-delay="100"
            >
              <div className="row gap-2">
                <div className="col-8 ligne">Football</div>
                <div className="col-3 ligne">Dames</div>
                <div className="col-5 ligne">1500 m</div>
                <div className="col-6 ligne">Awalé</div>
                <div className="col-6 ligne">Cyclisme</div>
                <div className="col-5 ligne">Volleyball</div>
                <div className="col-4 ligne">Ludo</div>
                <div className="col-7 ligne">Petits poteaux</div>
                <div className="col-7 ligne">Course en sac</div>
                <div className="col-4 ligne">Marathon</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </ResponsiveContainer>
  );
}
