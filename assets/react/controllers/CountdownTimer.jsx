import React, { useEffect, useState } from "react";

function CountdownTimer({ targetDate }) {
  const padWithZero = (num) => {
    return num.toString().padStart(2, "0");
  };
  const calculateTimeLeft = () => {
    // Conversion de targetDate en Date
    const target = new Date(targetDate);

    // Vérifier si target est une date valide
    if (isNaN(target.getTime())) {
      console.error("La date cible n'est pas valide");
      return {
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0,
      };
    }

    const now = new Date();
    const difference = +target - +now; // Différence entre la date cible et la date actuelle

    return {
      days: padWithZero(
        difference > 0 ? Math.floor(difference / (1000 * 60 * 60 * 24)) : 0
      ),
      hours: padWithZero(
        difference > 0 ? Math.floor((difference / (1000 * 60 * 60)) % 24) : 0
      ),
      minutes: padWithZero(
        difference > 0 ? Math.floor((difference / 1000 / 60) % 60) : 0
      ),
      seconds: padWithZero(
        difference > 0 ? Math.floor((difference / 1000) % 60) : 0
      ),
    };
  };

  const [timeLeft, setTimeLeft] = useState(calculateTimeLeft());

  useEffect(() => {
    const timer = setInterval(() => {
      setTimeLeft(calculateTimeLeft());
    }, 1000);

    return () => clearInterval(timer);
  }, [targetDate]);

  return (
    <>
      {/* Desktop */}
      <div className="d-none d-lg-block">
        <div
          style={{
            display: "flex",
            justifyContent: "center",
            gap: "20px",
            color: "#000",
            alignItems: "flex-start",
            marginTop: "30px",
          }}
        >
          <div style={{ marginTop: "8px", fontSize: "24px" }}>
            <strong style={{ marginRight: "5px", fontSize: "24px" }}>
              Olympiades des Mines 2024.
            </strong>
            13 - 14 Dec. 2024
          </div>

          <div
            className="d-flex flex-row align-items-center justify-content-center"
            style={{ gap: "20px" }}
          >
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.days}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Jours</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.hours}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Heures</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.minutes}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Minutes</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.seconds}
              </p>
              <span style={{ fontSize: "0.8rem" }}>Secondes</span>
            </div>
          </div>
        </div>
      </div>

      {/* Mobile */}
      <div className="d-block d-lg-none">
        <div
          style={{
            display: "flex",
            justifyContent: "center",
            gap: "20px",
            color: "#000",
            alignItems: "center",
            marginTop: "30px",
            flexDirection: "column",
          }}
        >
          <div style={{ marginTop: "8px" }}>
            <strong style={{ marginRight: "5px" }}>
              Olympiades des Mines 2024.
            </strong>
            13 - 14 Dec. 2024
          </div>

          <div
            className="d-flex flex-row align-items-center justify-content-center"
            style={{ gap: "20px" }}
          >
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.days}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Jours</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.hours}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Heures</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.minutes}
                <span style={{ color: "#0b8e36", marginLeft: "10px" }}>:</span>
              </p>
              <span style={{ fontSize: "0.8rem" }}>Minutes</span>
            </div>
            <div className="d-flex align-items-center flex-column">
              <p
                style={{
                  fontSize: "2rem",
                  marginBottom: "0",
                  color: "#f69322",
                }}
              >
                {timeLeft.seconds}
              </p>
              <span style={{ fontSize: "0.8rem" }}>Secondes</span>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default CountdownTimer;
