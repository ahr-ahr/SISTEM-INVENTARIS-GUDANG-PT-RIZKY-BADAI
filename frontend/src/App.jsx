import { Routes, Route, Navigate } from "react-router-dom";
import Login from "./pages/Login";
import Dashboard from "./components/Dashboard";
import TestRealtime from "./pages/TestRealtime";

export default function App() {
  return (
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/test-realtime" element={<TestRealtime />} />
      <Route path="*" element={<Navigate to="/" replace />} />
    </Routes>
  );
}