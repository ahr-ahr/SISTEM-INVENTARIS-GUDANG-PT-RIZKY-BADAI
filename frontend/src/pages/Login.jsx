import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

export default function App() {
  const navigate = useNavigate(); // TAMBAHKAN INI
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const [particles, setParticles] = useState([]);
  const [focusedInput, setFocusedInput] = useState(null);
  const [error, setError] = useState('');

  useEffect(() => {
    const newParticles = Array.from({ length: 60 }, (_, i) => ({
      id: i,
      x: Math.random() * 100,
      y: Math.random() * 100,
      size: Math.random() * 4 + 1,
      duration: Math.random() * 20 + 10,
      delay: Math.random() * 5
    }));
    setParticles(newParticles);
  }, []);

  // UBAH FUNCTION INI
  const handleSubmit = async () => {
    setError('');

    if (!username || !password) {
      setError('Username dan password harus diisi');
      return;
    }
    
    setIsLoading(true);
    
    try {
      const response = await fetch('http://localhost:8000/api/v1/login', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          username: username,
          password: password
        })
      });

      const data = await response.json();
      
      console.log('Response Status:', response.status);
      console.log('Response Data:', data);

      if (response.ok) {
        if (data.success === true) {
          const userData = {
            token: data.data?.token || '',
            user: data.data?.user || {}
          };

          // Simpan token ke localStorage
          localStorage.setItem('token', userData.token);
          localStorage.setItem('user', JSON.stringify(userData.user));

          // Redirect ke dashboard
          navigate('/dashboard', { 
            state: { 
              user: userData 
            } 
          });
          
        } else {
          setError(data.message || 'Login gagal. Periksa username dan password Anda.');
        }
      } else {
        setError(data.message || `Error ${response.status}: Terjadi kesalahan pada server.`);
      }
    } catch (err) {
      console.error('Error Detail:', err);
      setError('Terjadi kesalahan koneksi. Pastikan server berjalan di http://localhost:8000');
    } finally {
      setIsLoading(false);
    }
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      handleSubmit();
    }
  };

  return (
    <div className="min-h-screen w-full bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 flex items-center justify-center p-4 lg:p-6 xl:p-8 relative overflow-hidden">
      {/* Animated Background Particles */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none">
        {particles.map((particle) => (
          <div
            key={particle.id}
            className="absolute rounded-full bg-blue-300 opacity-20"
            style={{
              left: `${particle.x}%`,
              top: `${particle.y}%`,
              width: `${particle.size}px`,
              height: `${particle.size}px`,
              animation: `float ${particle.duration}s infinite ease-in-out`,
              animationDelay: `${particle.delay}s`
            }}
          />
        ))}
      </div>

      {/* Gradient Orbs */}
      <div className="hidden sm:block absolute top-10 sm:top-20 left-10 sm:left-20 w-48 sm:w-64 md:w-72 lg:w-80 h-48 sm:h-64 md:h-72 lg:h-80 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob" />
      <div className="hidden sm:block absolute top-20 sm:top-40 right-10 sm:right-20 w-48 sm:w-64 md:w-72 lg:w-80 h-48 sm:h-64 md:h-72 lg:h-80 bg-slate-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000" />
      <div className="hidden md:block absolute bottom-20 left-40 w-72 lg:w-80 h-72 lg:h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000" />

      {/* Main Container */}
      <div className="w-full h-full flex items-center justify-center">
        <div className="w-full max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16 items-center">
          
          {/* Left Side - Brand Info */}
          <div className="hidden lg:flex flex-col justify-center px-4 xl:px-8">
            <div className="relative max-w-2xl">
              {/* Glow effect for title */}
              <div className="absolute -inset-4 bg-gradient-to-r from-blue-600 to-blue-500 rounded-3xl blur-2xl opacity-20 animate-pulse" />
              
              <div className="relative space-y-6 xl:space-y-8">
                {/* Logo/Icon */}
                <div className="inline-flex items-center justify-center w-20 h-20 xl:w-24 xl:h-24 bg-gradient-to-br from-blue-600 to-blue-500 rounded-3xl shadow-2xl animate-bounce-slow">
                  <svg className="w-10 h-10 xl:w-12 xl:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>

                {/* Title */}
                <div>
                  <h1 className="text-4xl xl:text-5xl 2xl:text-6xl font-bold text-white mb-3 xl:mb-4 leading-tight">
                    PT Rizky Badai
                  </h1>
                  <div className="h-1 w-24 xl:w-32 bg-gradient-to-r from-blue-600 to-blue-500 rounded-full mb-4 xl:mb-6" />
                  <p className="text-lg xl:text-xl 2xl:text-2xl text-slate-200 font-light">
                    Sistem Inventaris & Pendataan Barang Gudang
                  </p>
                </div>

                {/* Features List */}
                <div className="space-y-4 xl:space-y-5 mt-8 xl:mt-10">
                  <div className="flex items-start gap-4 group">
                    <div className="flex-shrink-0 w-12 h-12 xl:w-14 xl:h-14 bg-blue-600/20 rounded-xl flex items-center justify-center group-hover:bg-blue-600/30 transition-colors">
                      <svg className="w-6 h-6 xl:w-7 xl:h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </div>
                    <div className="flex-1">
                      <h3 className="text-white font-semibold mb-1 text-base xl:text-lg">Manajemen Terintegrasi</h3>
                      <p className="text-slate-300 text-sm xl:text-base">Kelola semua data inventaris dalam satu sistem</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4 group">
                    <div className="flex-shrink-0 w-12 h-12 xl:w-14 xl:h-14 bg-slate-500/20 rounded-xl flex items-center justify-center group-hover:bg-slate-500/30 transition-colors">
                      <svg className="w-6 h-6 xl:w-7 xl:h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                      </svg>
                    </div>
                    <div className="flex-1">
                      <h3 className="text-white font-semibold mb-1 text-base xl:text-lg">Keamanan Terjamin</h3>
                      <p className="text-slate-300 text-sm xl:text-base">Data terenkripsi dengan standar keamanan tinggi</p>
                    </div>
                  </div>

                  <div className="flex items-start gap-4 group">
                    <div className="flex-shrink-0 w-12 h-12 xl:w-14 xl:h-14 bg-blue-500/20 rounded-xl flex items-center justify-center group-hover:bg-blue-500/30 transition-colors">
                      <svg className="w-6 h-6 xl:w-7 xl:h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 10V3L4 14h7v7l9-11h-7z" />
                      </svg>
                    </div>
                    <div className="flex-1">
                      <h3 className="text-white font-semibold mb-1 text-base xl:text-lg">Akses Real-time</h3>
                      <p className="text-slate-300 text-sm xl:text-base">Pantau stok dan data gudang kapan saja</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Right Side - Login Card */}
          <div className="relative w-full flex items-center justify-center lg:justify-end px-4">
            <div className="w-full max-w-md lg:max-w-lg xl:max-w-xl">
              {/* Glow Effect */}
              <div className="absolute -inset-1 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 rounded-2xl md:rounded-3xl blur opacity-25 transition duration-1000 animate-pulse" />
              
              {/* Main Card */}
              <div className="relative bg-white/95 backdrop-blur-xl rounded-2xl md:rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-10 xl:p-12 border border-slate-200">
                {/* Mobile/Tablet Header */}
                <div className="text-center mb-6 sm:mb-8 lg:hidden">
                  <div className="inline-flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-600 to-blue-500 rounded-2xl mb-4 animate-bounce-slow">
                    <svg className="w-7 h-7 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                  </div>
                  <h1 className="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">
                    PT Rizky Badai
                  </h1>
                  <p className="text-sm sm:text-base text-slate-600">Sistem Inventaris & Pendataan Barang Gudang</p>
                </div>

                {/* Desktop Header */}
                <div className="hidden lg:block text-center mb-8 xl:mb-10">
                  <h2 className="text-2xl xl:text-3xl font-bold text-slate-800 mb-2">
                    Login Sistem
                  </h2>
                  <p className="text-slate-600 text-sm xl:text-base">Masuk ke dashboard inventaris</p>
                </div>

                {/* Error Message */}
                {error && (
                  <div className="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg xl:rounded-xl">
                    <div className="flex items-start gap-3">
                      <svg className="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <p className="text-red-600 text-sm xl:text-base">{error}</p>
                    </div>
                  </div>
                )}

                {/* Form */}
                <div className="space-y-5 xl:space-y-6">
                  {/* Username Input */}
                  <div className="relative">
                    <label className="block text-sm xl:text-base font-medium text-slate-700 mb-2">
                      Username
                    </label>
                    <div className="relative">
                      <div className={`absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg xl:rounded-xl blur transition-opacity duration-300 ${focusedInput === 'username' ? 'opacity-30' : 'opacity-0'}`} />
                      <div className="relative">
                        <input
                          type="text"
                          value={username}
                          onChange={(e) => setUsername(e.target.value)}
                          onFocus={() => setFocusedInput('username')}
                          onBlur={() => setFocusedInput(null)}
                          onKeyPress={handleKeyPress}
                          disabled={isLoading}
                          className="w-full px-4 py-3 xl:py-4 text-sm xl:text-base bg-white border border-slate-300 rounded-lg xl:rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                          placeholder="Masukkan username"
                        />
                        <div className="absolute right-3 xl:right-4 top-1/2 -translate-y-1/2">
                          <svg className="w-5 h-5 xl:w-6 xl:h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                          </svg>
                        </div>
                      </div>
                    </div>
                  </div>

                  {/* Password Input */}
                  <div className="relative">
                    <label className="block text-sm xl:text-base font-medium text-slate-700 mb-2">
                      Password
                    </label>
                    <div className="relative">
                      <div className={`absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg xl:rounded-xl blur transition-opacity duration-300 ${focusedInput === 'password' ? 'opacity-30' : 'opacity-0'}`} />
                      <div className="relative">
                        <input
                          type={showPassword ? 'text' : 'password'}
                          value={password}
                          onChange={(e) => setPassword(e.target.value)}
                          onFocus={() => setFocusedInput('password')}
                          onBlur={() => setFocusedInput(null)}
                          onKeyPress={handleKeyPress}
                          disabled={isLoading}
                          className="w-full px-4 py-3 xl:py-4 text-sm xl:text-base bg-white border border-slate-300 rounded-lg xl:rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                          placeholder="Masukkan password"
                        />
                        <button
                          type="button"
                          onClick={() => setShowPassword(!showPassword)}
                          disabled={isLoading}
                          className="absolute right-3 xl:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-colors disabled:opacity-50"
                        >
                          {showPassword ? (
                            <svg className="w-5 h-5 xl:w-6 xl:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                          ) : (
                            <svg className="w-5 h-5 xl:w-6 xl:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                          )}
                        </button>
                      </div>
                    </div>
                  </div>

                  {/* Forgot Password */}
                  <div className="flex items-center justify-end text-xs xl:text-sm">
                    <a href="#" className="text-blue-600 hover:text-blue-700 transition-colors font-medium">
                      Lupa password?
                    </a>
                  </div>

                  {/* Submit Button */}
                  <button
                    onClick={handleSubmit}
                    disabled={isLoading}
                    className="relative w-full py-3 xl:py-4 px-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium text-sm xl:text-base rounded-lg xl:rounded-xl overflow-hidden group hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                  >
                    <span className="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-600 to-blue-700 group-hover:scale-105 transition-transform duration-300" />
                    <span className="relative flex items-center justify-center">
                      {isLoading ? (
                        <>
                          <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                          </svg>
                          Memproses...
                        </>
                      ) : (
                        'Login'
                      )}
                    </span>
                  </button>
                </div>

                {/* Footer Info */}
                <p className="mt-6 xl:mt-8 text-center text-xs xl:text-sm text-slate-500">
                  Lupa password? Hubungi administrator sistem
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <style>{`
        @keyframes float {
          0%, 100% {
            transform: translateY(0) translateX(0);
          }
          50% {
            transform: translateY(-20px) translateX(10px);
          }
        }
        
        @keyframes blob {
          0%, 100% {
            transform: translate(0, 0) scale(1);
          }
          33% {
            transform: translate(30px, -50px) scale(1.1);
          }
          66% {
            transform: translate(-20px, 20px) scale(0.9);
          }
        }
        
        .animate-blob {
          animation: blob 7s infinite;
        }
        
        .animation-delay-2000 {
          animation-delay: 2s;
        }
        
        .animation-delay-4000 {
          animation-delay: 4s;
        }
        
        .animate-bounce-slow {
          animation: bounce 3s infinite;
        }
      `}</style>
    </div>
  );
}