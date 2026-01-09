import { Routes, Route } from "react-router-dom";
import Home from "./pages/Login";

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
    </Routes>
  );
}
