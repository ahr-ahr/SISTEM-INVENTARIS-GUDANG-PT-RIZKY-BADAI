// File: src/utils/api.js
// Utility untuk handle semua API request dengan token

const API_BASE_URL = 'https://api.sig-pt-rizky-badai.com:8443/api/v1';

// Function untuk get token dari localStorage
const getToken = () => {
  return localStorage.getItem('token');
};

// Function untuk API request dengan token
export const apiRequest = async (endpoint, options = {}) => {
  const token = getToken();
  
  const defaultHeaders = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  };

  // Tambahkan Bearer Token kalau ada
  if (token) {
    defaultHeaders['Authorization'] = `Bearer ${token}`;
  }

  const config = {
    ...options,
    headers: {
      ...defaultHeaders,
      ...options.headers,
    },
  };

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
    const data = await response.json();

    // Kalau unauthorized (401), redirect ke login
    if (response.status === 401) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/';
      throw new Error('Session expired, please login again');
    }

    return { response, data };
  } catch (error) {
    console.error('API Request Error:', error);
    throw error;
  }
};

// Shorthand methods
export const api = {
  get: (endpoint, options = {}) => 
    apiRequest(endpoint, { ...options, method: 'GET' }),
  
  post: (endpoint, body, options = {}) => 
    apiRequest(endpoint, { 
      ...options, 
      method: 'POST',
      body: JSON.stringify(body)
    }),
  
  put: (endpoint, body, options = {}) => 
    apiRequest(endpoint, { 
      ...options, 
      method: 'PUT',
      body: JSON.stringify(body)
    }),
  
  delete: (endpoint, options = {}) => 
    apiRequest(endpoint, { ...options, method: 'DELETE' }),
};

// Export untuk dipakai di komponen lain
export default api;