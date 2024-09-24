import React from "react";
import Carousel from "./Carousel";
import AccueilPresentation from "./AccueilPresentation";
import AccueilActivite from "./AccueilActivite";
import AccueilDiscipline from "./AccueilDiscipline";
import CountdownTimer from "./CountdownTimer";

export default function () {
  return (
    <div>
      <Carousel />
      <CountdownTimer targetDate="2024-12-13T00:00:00" />
      <AccueilPresentation />
      <AccueilActivite />
      <AccueilDiscipline />
    </div>
  );
}
