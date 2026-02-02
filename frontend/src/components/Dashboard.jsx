// src/components/Dashboard.jsx
import { useState, useEffect } from 'react';
import { Link, useNavigate, useLocation } from 'react-router-dom';
import api from '../utils/api';

export default function Dashboard() {
  const navigate = useNavigate();
  const location = useLocation();
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [activeSection, setActiveSection] = useState('dashboard'); // 'dashboard', 'kategori', 'barang', 'transaksi', 'laporan'
  const [categories, setCategories] = useState([]);
  const [barangList, setBarangList] = useState([]);
  const [supplierList, setSupplierList] = useState([]);
  const [warehouseList, setWarehouseList] = useState([]);
  const [locationList, setLocationList] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [modalMode, setModalMode] = useState('create');
  const [modalType, setModalType] = useState('category'); // 'category', 'barang', 'receiving', 'dispatch', 'adjustment'
  const [selectedCategory, setSelectedCategory] = useState(null);
  const [selectedBarang, setSelectedBarang] = useState(null);
  const [loading, setLoading] = useState(false);
  const [showActiveOnly, setShowActiveOnly] = useState(true);
  const [toggleLoading, setToggleLoading] = useState({});
  const [deleteReason, setDeleteReason] = useState('');
const [showDeleteModal, setShowDeleteModal] = useState(false);
const [barangToDelete, setBarangToDelete] = useState(null);
const [transaksiList, setTransaksiList] = useState([]);
const [selectedTransaksi, setSelectedTransaksi] = useState(null);
const [showTransaksiDetail, setShowTransaksiDetail] = useState(false);
// State untuk Laporan
const [laporanType, setLaporanType] = useState('stok'); // 'stok' atau 'mutasi'
const [laporanStok, setLaporanStok] = useState([]);
const [laporanMutasi, setLaporanMutasi] = useState([]);
const [filterLaporan, setFilterLaporan] = useState({
  keyword: '',
  stok_min: '',
  stok_max: '',
  barang_id: '',
  jenis: '',
  sumber: '',
  tanggal_dari: '',
  tanggal_sampai: ''
});
  const [stats, setStats] = useState({
    totalKategori: 0,
    totalBarang: 0,
    transaksiHariIni: 0,
    stokMenipis: 0
  });
  
  const [formData, setFormData] = useState({
    kode: '',
    nama: '',
    deskripsi: '',
    is_active: true
  });

  // Form data untuk barang
  const [barangForm, setBarangForm] = useState({
    kode: '',
    nama: '',
    category_id: '',
    satuan: '',
    stok_min: '',
    deskripsi: ''
  });

  // Form data untuk receiving
  const [receivingForm, setReceivingForm] = useState({
    supplier_id: '',
    warehouse_id: '',
    location_id: '',
    barang_id: '',
    jumlah: 1,
    keterangan: ''
  });

  // Form data untuk dispatch
  const [dispatchForm, setDispatchForm] = useState({
    barang_id: '',
    warehouse_id: '',
    location_id: '',
    jumlah: 1,
    tujuan: '',
    keterangan: ''
  });

  // Form data untuk stock adjustment
  const [adjustmentForm, setAdjustmentForm] = useState({
    barang_id: '',
    stok_fisik: 0,
    alasan: ''
  });

  // Form data untuk transfer
const [transferForm, setTransferForm] = useState({
  warehouse_id: '',
  barang_id: '',
  from_location_id: '',
  to_location_id: '',
  jumlah: 1,
  alasan: ''
});

const [transferList, setTransferList] = useState([]);
const [selectedTransfer, setSelectedTransfer] = useState(null);
const [showTransferDetail, setShowTransferDetail] = useState(false);
const [showApprovalModal, setShowApprovalModal] = useState(false);
const [approvalAction, setApprovalAction] = useState(''); // 'approve' atau 'reject'
const [rejectionReason, setRejectionReason] = useState('');

  const [userData, setUserData] = useState(null);

  useEffect(() => {
    const user = location.state?.user;
    const storedToken = localStorage.getItem('token');
    const storedUser = localStorage.getItem('user');
    
    if (!storedToken) {
      navigate('/');
      return;
    }
    
    if (user) {
      setUserData(user);
    } else if (storedUser) {
      setUserData({ user: JSON.parse(storedUser) });
    }
    
    fetchCategories();
    fetchBarang();
    fetchSuppliers();
    fetchWarehouses();
    fetchTransaksi();
    fetchStats();
    fetchLaporanStok();
  }, [location.state, navigate]);

  const fetchCategories = async () => {
    setLoading(true);
    try {
      const { response, data } = await api.get('/inventory/categories');
      
      if (data.success) {
        if (typeof data.data.items === 'string') {
          const parsedItems = JSON.parse(data.data.items);
          setCategories(parsedItems);
        } else if (Array.isArray(data.data.items)) {
          setCategories(data.data.items);
        } else if (Array.isArray(data.data)) {
          setCategories(data.data);
        }
      }
    } catch (error) {
      console.error('Error:', error);
    }
    setLoading(false);
  };

  const fetchBarang = async () => {
    try {
      const { response, data } = await api.get('/inventory/barangs');
      
      if (data.success) {
        if (typeof data.data.items === 'string') {
          const parsedItems = JSON.parse(data.data.items);
          setBarangList(parsedItems);
        } else if (Array.isArray(data.data.items)) {
          setBarangList(data.data.items);
        } else if (Array.isArray(data.data)) {
          setBarangList(data.data);
        }
      }
    } catch (error) {
      console.error('Error fetching barang:', error);
    }
  };

  const fetchSuppliers = async () => {
    try {
      const { response, data } = await api.get('/inventory/suppliers');
      
      if (data.success) {
        if (typeof data.data.items === 'string') {
          const parsedItems = JSON.parse(data.data.items);
          setSupplierList(parsedItems);
        } else if (Array.isArray(data.data.items)) {
          setSupplierList(data.data.items);
        } else if (Array.isArray(data.data)) {
          setSupplierList(data.data);
        }
      }
    } catch (error) {
      console.error('Error fetching suppliers:', error);
      setSupplierList([]);
    }
  };

  const fetchWarehouses = async () => {
    try {
      const { response, data } = await api.get('/inventory/warehouses');
      
      if (data.success) {
        if (typeof data.data.items === 'string') {
          const parsedItems = JSON.parse(data.data.items);
          setWarehouseList(parsedItems);
        } else if (Array.isArray(data.data.items)) {
          setWarehouseList(data.data.items);
        } else if (Array.isArray(data.data)) {
          setWarehouseList(data.data);
        }
      }
    } catch (error) {
      console.error('Error fetching warehouses:', error);
      setWarehouseList([]);
    }
  };

  const fetchLocations = async () => {
    try {
      const { response, data } = await api.get('/inventory/locations');
      
      if (data.success) {
        if (typeof data.data.items === 'string') {
          const parsedItems = JSON.parse(data.data.items);
          setLocationList(parsedItems);
        } else if (Array.isArray(data.data.items)) {
          setLocationList(data.data.items);
        } else if (Array.isArray(data.data)) {
          setLocationList(data.data);
        }
      }
    } catch (error) {
      console.error('Error fetching locations:', error);
      setLocationList([]);
    }
  };

  const fetchStats = async () => {
    try {
      const { data } = await api.get('/inventory/laporan/stok');
      
      if (data.success) {
        let items = [];
        if (typeof data.data.items === 'string') {
          items = JSON.parse(data.data.items);
        } else if (Array.isArray(data.data.items)) {
          items = data.data.items;
        }
        
        setStats(prev => ({
          ...prev,
          totalBarang: items.length,
          stokMenipis: items.filter(item => item.stok < 10).length
        }));
      }
    } catch (error) {
      console.error('Error fetching stats:', error);
    }
  };

  const fetchTransaksi = async () => {
  try {
    const { response, data } = await api.get('/inventory/transaksi-stok');
    
    if (data.success) {
      if (Array.isArray(data.data)) {
        setTransaksiList(data.data);
      }
    }
  } catch (error) {
    console.error('Error fetching transaksi:', error);
    setTransaksiList([]);
  }
};

const fetchTransaksiDetail = async (id) => {
  try {
    const { response, data } = await api.get(`/inventory/transaksi-stok/${id}`);
    
    if (data.success) {
      setSelectedTransaksi(data.data);
      setShowTransaksiDetail(true);
    }
  } catch (error) {
    console.error('Error fetching transaksi detail:', error);
    alert('Gagal memuat detail transaksi');
  }
};

const fetchLaporanStok = async () => {
  setLoading(true);
  try {
    const params = new URLSearchParams();
    if (filterLaporan.keyword) params.append('keyword', filterLaporan.keyword);
    if (filterLaporan.stok_min) params.append('stok_min', filterLaporan.stok_min);
    if (filterLaporan.stok_max) params.append('stok_max', filterLaporan.stok_max);
    
    const { data } = await api.get(`/inventory/laporan/stok?${params.toString()}`);
    
    if (data.success) {
      if (typeof data.data.items === 'string') {
        const parsedItems = JSON.parse(data.data.items);
        setLaporanStok(parsedItems);
      } else if (Array.isArray(data.data.items)) {
        setLaporanStok(data.data.items);
      }
    }
  } catch (error) {
    console.error('Error fetching laporan stok:', error);
    setLaporanStok([]);
  }
  setLoading(false);
};

const fetchLaporanMutasi = async () => {
  setLoading(true);
  try {
    const params = new URLSearchParams();
    if (filterLaporan.barang_id) params.append('barang_id', filterLaporan.barang_id);
    if (filterLaporan.jenis) params.append('jenis', filterLaporan.jenis);
    if (filterLaporan.sumber) params.append('sumber', filterLaporan.sumber);
    if (filterLaporan.tanggal_dari) params.append('tanggal_dari', filterLaporan.tanggal_dari);
    if (filterLaporan.tanggal_sampai) params.append('tanggal_sampai', filterLaporan.tanggal_sampai);
    
    const { data } = await api.get(`/inventory/laporan/mutasi-stok?${params.toString()}`);
    
    if (data.success) {
      if (typeof data.data.items === 'string') {
        const parsedItems = JSON.parse(data.data.items);
        setLaporanMutasi(parsedItems);
      } else if (Array.isArray(data.data.items)) {
        setLaporanMutasi(data.data.items);
      }
    }
  } catch (error) {
    console.error('Error fetching laporan mutasi:', error);
    setLaporanMutasi([]);
  }
  setLoading(false);
};

const handleResetFilter = () => {
  setFilterLaporan({
    keyword: '',
    stok_min: '',
    stok_max: '',
    barang_id: '',
    jenis: '',
    sumber: '',
    tanggal_dari: '',
    tanggal_sampai: ''
  });
};

const getJenisTransaksiBadge = (jenis) => {
  const badges = {
    'masuk': 'bg-green-100 text-green-800',
    'keluar': 'bg-red-100 text-red-800',
    'penyesuaian': 'bg-orange-100 text-orange-800'
  };
  return badges[jenis] || 'bg-gray-100 text-gray-800';
};

const formatDateTime = (dateString) => {
  if (!dateString) return '-';
  const date = new Date(dateString);
  return date.toLocaleString('id-ID', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

  const handleCreate = async (e) => {
    e.preventDefault();
    try {
      const { response, data } = await api.post('/inventory/categories', formData);
      
      if (data.success) {
        fetchCategories();
        setShowModal(false);
        resetForm();
        alert('Kategori berhasil ditambahkan!');
      } else {
        alert(data.message || 'Gagal menambahkan kategori');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat menambahkan kategori');
    }
  };

  const handleUpdate = async (e) => {
    e.preventDefault();
    try {
      const { response, data } = await api.put(`/inventory/categories/${selectedCategory.id}`, {
        nama: formData.nama,
        deskripsi: formData.deskripsi,
        is_active: formData.is_active
      });
      
      if (data.success) {
        fetchCategories();
        setShowModal(false);
        resetForm();
        alert('Kategori berhasil diperbarui!');
      } else {
        alert(data.message || 'Gagal memperbarui kategori');
      }
    } catch (error) {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat memperbarui kategori');
    }
  };

  const handleToggleActive = async (category) => {
    const newStatus = !category.is_active;
    setToggleLoading(prev => ({ ...prev, [category.id]: true }));
    
    try {
      const { response, data } = await api.put(`/inventory/categories/${category.id}`, {
        nama: category.nama,
        deskripsi: category.deskripsi,
        is_active: newStatus
      });
      
      if (response.ok || data.success) {
        setCategories(prevCategories => 
          prevCategories.map(cat => 
            cat.id === category.id 
              ? { ...cat, is_active: newStatus }
              : cat
          )
        );
      } else {
        alert(data.message || 'Gagal mengubah status kategori');
      }
    } catch (error) {
      console.error('Toggle Error:', error);
      alert('Terjadi kesalahan saat mengubah status kategori');
    } finally {
      setToggleLoading(prev => {
        const newState = { ...prev };
        delete newState[category.id];
        return newState;
      });
    }
  };

 const handleCreateBarang = async (e) => {
    e.preventDefault();
    try {
      const { data } = await api.post('/inventory/barangs', {
        kode: barangForm.kode,
        nama: barangForm.nama,
        category_id: barangForm.category_id, // ✅ Kirim sebagai string
        satuan: barangForm.satuan,
        stok_min: parseInt(barangForm.stok_min),
        deskripsi: barangForm.deskripsi || null
      });
      
      if (data.success) {
        alert('Barang berhasil ditambahkan!');
        setShowModal(false);
        resetBarangForm();
        fetchBarang();
        fetchStats();
      } else {
        alert(data.message || 'Gagal menambahkan barang');
      }
    } catch (error) {
      console.error('Error creating barang:', error);
      alert('Terjadi kesalahan saat menambahkan barang: ' + (error.message || 'Unknown error'));
    }
  };

  // Handler untuk Receiving Barang
  const handleReceiving = async (e) => {
    e.preventDefault();
    try {
      const { data } = await api.post('/inventory/receivings', {
        supplier_id: parseInt(receivingForm.supplier_id),
        warehouse_id: parseInt(receivingForm.warehouse_id),
        location_id: parseInt(receivingForm.location_id),
        barang_id: parseInt(receivingForm.barang_id),
        jumlah: parseInt(receivingForm.jumlah),
        keterangan: receivingForm.keterangan || null
      });
      
      if (data.success) {
        alert('Penerimaan barang berhasil diajukan!');
        setShowModal(false);
        resetReceivingForm();
        fetchStats();
        fetchBarang();
      } else {
        alert(data.message || 'Gagal mengajukan penerimaan');
      }
    } catch (error) {
      console.error('Error receiving:', error);
      alert('Terjadi kesalahan saat mengajukan penerimaan: ' + (error.message || 'Unknown error'));
    }
  };

  // Handler untuk Dispatch Barang
  const handleDispatch = async (e) => {
    e.preventDefault();
    try {
      const { data } = await api.post('/inventory/dispatch', {
        barang_id: parseInt(dispatchForm.barang_id),
        warehouse_id: parseInt(dispatchForm.warehouse_id),
        location_id: parseInt(dispatchForm.location_id),
        jumlah: parseInt(dispatchForm.jumlah),
        tujuan: dispatchForm.tujuan,
        keterangan: dispatchForm.keterangan || null
      });
      
      if (data.success) {
        alert('Dispatch barang berhasil dibuat!');
        setShowModal(false);
        resetDispatchForm();
        fetchStats();
      } else {
        alert(data.message || 'Gagal membuat dispatch');
      }
    } catch (error) {
      console.error('Error dispatch:', error);
      alert('Terjadi kesalahan saat membuat dispatch: ' + (error.message || 'Unknown error'));
    }
  };

  // Handler untuk Stock Adjustment
  const handleAdjustment = async (e) => {
    e.preventDefault();
    try {
      const { data } = await api.post('/inventory/adjustment', {
        barang_id: parseInt(adjustmentForm.barang_id),
        stok_fisik: parseInt(adjustmentForm.stok_fisik),
        alasan: adjustmentForm.alasan
      });
      
      if (data.success) {
        alert('Permintaan penyesuaian stok berhasil diajukan!');
        setShowModal(false);
        resetAdjustmentForm();
        fetchStats();
        fetchBarang();
      } else {
        alert(data.message || 'Gagal mengajukan penyesuaian stok');
      }
    } catch (error) {
      console.error('Error adjustment:', error);
      alert('Terjadi kesalahan saat mengajukan penyesuaian: ' + (error.message || 'Unknown error'));
    }
  };

  // Handler untuk edit barang
const handleUpdateBarang = async (e) => {
  e.preventDefault();
  
  // Gunakan identifier yang konsisten
  const barangId = selectedBarang.barang_id || selectedBarang.id;
  
  console.log('Update Barang ID:', barangId);
  console.log('Selected Barang:', selectedBarang);
  
  if (!barangId) {
    alert('Error: ID barang tidak ditemukan');
    return;
  }
  
  try {
    const { response, data } = await api.put(`/inventory/barangs/${barangId}`, {
      kode: barangForm.kode,
      nama: barangForm.nama,
      category_id: barangForm.category_id, // ✅ Kirim sebagai string
      satuan: barangForm.satuan,
      stok_min: parseInt(barangForm.stok_min),
      deskripsi: barangForm.deskripsi || null
    });
    
    if (data.success) {
      alert('Barang berhasil diperbarui!');
      setShowModal(false);
      resetBarangForm();
      setSelectedBarang(null);
      fetchBarang();
      fetchStats();
    } else {
      alert(data.message || 'Gagal memperbarui barang');
    }
  } catch (error) {
    console.error('Error updating barang:', error);
    alert('Terjadi kesalahan saat memperbarui barang: ' + (error.message || 'Unknown error'));
  }
};

const handleDeleteBarang = async (barang) => {
  setBarangToDelete(barang);
  setShowDeleteModal(true);
};

const confirmDeleteBarang = async () => {
  if (!deleteReason) {
    alert('Silakan pilih alasan penonaktifan');
    return;
  }

  const barangId = barangToDelete.barang_id || barangToDelete.id;
  
  if (!barangId) {
    alert('Error: ID barang tidak ditemukan');
    return;
  }
  
  setToggleLoading(prev => ({ ...prev, [barangId]: true }));
  
  try {
    const { response, data } = await api.delete(`/inventory/barangs/${barangId}?reason=${deleteReason}`);
    
    if (response.ok || data.success) {
      alert('Barang berhasil dinonaktifkan!');
      setShowDeleteModal(false);
      setDeleteReason('');
      setBarangToDelete(null);
      fetchBarang();
      fetchStats();
    } else {
      alert(data.message || 'Gagal menonaktifkan barang');
    }
  } catch (error) {
    console.error('Delete barang error:', error);
    alert('Terjadi kesalahan saat menonaktifkan barang');
  } finally {
    setToggleLoading(prev => {
      const newState = { ...prev };
      delete newState[barangId];
      return newState;
    });
  }
};

  const openCreateModal = () => {
    setModalMode('create');
    setModalType('category');
    resetForm();
    setShowModal(true);
  };

  const openEditModal = (category) => {
    setModalMode('edit');
    setModalType('category');
    setSelectedCategory(category);
    setFormData({
      kode: category.kode,
      nama: category.nama,
      deskripsi: category.deskripsi || '',
      is_active: category.is_active
    });
    setShowModal(true);
  };

  const openCreateBarangModal = () => {
    setModalType('barang');
    setModalMode('create');
    resetBarangForm();
    setShowModal(true);
  };

  const openEditBarangModal = (barang) => {
  setModalType('barang');
  setModalMode('edit');
  setSelectedBarang(barang);
  setBarangForm({
    kode: barang.kode,
    nama: barang.nama,
    category_id: barang.category_id,
    satuan: barang.satuan,
    stok_min: barang.stok_min,
    deskripsi: barang.deskripsi || ''
  });
  setShowModal(true);
};

  const openReceivingModal = () => {
    setModalType('receiving');
    resetReceivingForm();
    setShowModal(true);
  };

  const openDispatchModal = () => {
    setModalType('dispatch');
    resetDispatchForm();
    setShowModal(true);
  };

  const openAdjustmentModal = () => {
    setModalType('adjustment');
    resetAdjustmentForm();
    setShowModal(true);
  };

  const resetForm = () => {
    setFormData({
      kode: '',
      nama: '',
      deskripsi: '',
      is_active: true
    });
    setSelectedCategory(null);
  };

  const resetBarangForm = () => {
    setBarangForm({
      kode: '',
      nama: '',
      category_id: '',
      satuan: '',
      stok_min: '',
      deskripsi: ''
    });
  };

  const resetReceivingForm = () => {
    setReceivingForm({
      supplier_id: '',
      warehouse_id: '',
      location_id: '',
      barang_id: '',
      jumlah: 1,
      keterangan: ''
    });
  };

  const resetDispatchForm = () => {
    setDispatchForm({
      barang_id: '',
      warehouse_id: '',
      location_id: '',
      jumlah: 1,
      tujuan: '',
      keterangan: ''
    });
  };

  const resetAdjustmentForm = () => {
    setAdjustmentForm({
      barang_id: '',
      stok_fisik: 0,
      alasan: ''
    });
  };

  const handleLogout = async () => {
    if (!confirm('Apakah Anda yakin ingin logout?')) return;
    
    try {
      await api.post('/logout');
    } catch (error) {
      console.error('Logout error:', error);
    } finally {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      navigate('/');
    }
  };

  const filteredCategories = showActiveOnly 
    ? categories.filter(cat => cat.is_active === true)
    : categories.filter(cat => cat.is_active === false);

  // Get selected barang info for adjustment form
const getSelectedBarangInfo = () => {
  const barang = barangList.find(b => b.barang_id === parseInt(adjustmentForm.barang_id));
  return barang || null;
};

const selectedBarangForAdjustment = getSelectedBarangInfo();

  // Render section berdasarkan activeSection
  const renderContent = () => {
    switch (activeSection) {
      case 'dashboard':
        return (
          <>
            {/* Stats Cards */}
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
              <div className="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div className="flex items-center justify-between mb-4">
                  <div className="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                  </div>
                </div>
                <p className="text-3xl font-bold mb-1">{categories.length}</p>
                <p className="text-blue-100 text-sm">Total Kategori</p>
              </div>

              <div className="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div className="flex items-center justify-between mb-4">
                  <div className="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                  </div>
                </div>
                <p className="text-3xl font-bold mb-1">{stats.totalBarang}</p>
                <p className="text-green-100 text-sm">Total Barang</p>
              </div>

              <div className="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl p-6 text-white shadow-lg">
                <div className="flex items-center justify-between mb-4">
                  <div className="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                </div>
                <p className="text-3xl font-bold mb-1">{stats.transaksiHariIni}</p>
                <p className="text-yellow-100 text-sm">Transaksi Hari Ini</p>
              </div>

              <div className="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div className="flex items-center justify-between mb-4">
                  <div className="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                </div>
                <p className="text-3xl font-bold mb-1">{stats.stokMenipis}</p>
                <p className="text-purple-100 text-sm">Stok Menipis</p>
              </div>
            </div>

            {/* Quick Actions */}
            <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
              <h3 className="text-lg font-semibold text-gray-800 mb-4">Transaksi Cepat</h3>
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <button 
                  onClick={openReceivingModal}
                  className="flex items-center gap-3 p-4 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition-colors"
                >
                  <div className="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                    </svg>
                  </div>
                  <div className="text-left">
                    <p className="font-medium text-gray-800">Penerimaan Barang</p>
                    <p className="text-xs text-gray-600">Ajukan penerimaan dari supplier</p>
                  </div>
                </button>

                <button 
                  onClick={openDispatchModal}
                  className="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition-colors"
                >
                  <div className="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                  </div>
                  <div className="text-left">
                    <p className="font-medium text-gray-800">Dispatch Barang</p>
                    <p className="text-xs text-gray-600">Kirim barang ke lokasi lain</p>
                  </div>
                </button>

                <button 
                  onClick={openAdjustmentModal}
                  className="flex items-center gap-3 p-4 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition-colors"
                >
                  <div className="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg className="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </div>
                  <div className="text-left">
                    <p className="font-medium text-gray-800">Penyesuaian Stok</p>
                    <p className="text-xs text-gray-600">Sesuaikan stok dengan fisik</p>
                  </div>
                </button>
              </div>
            </div>
          </>
        );

      case 'kategori':
        return (
          <div className="bg-white rounded-xl shadow-sm border border-gray-200">
            <div className="flex items-center justify-between px-6 py-4 border-b border-gray-200">
              <h3 className="text-lg font-semibold text-gray-800">Data Kategori</h3>
              <div className="flex items-center gap-3">
                <div className="flex items-center gap-2">
                  <label htmlFor="status-filter" className="text-sm text-gray-600">Tampilkan:</label>
                  <select
                    id="status-filter"
                    value={showActiveOnly ? 'active' : 'inactive'}
                    onChange={(e) => setShowActiveOnly(e.target.value === 'active')}
                    className="px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white cursor-pointer"
                  >
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                  </select>
                </div>
                
                <button onClick={openCreateModal} className="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                  <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
                  </svg>
                  <span className="font-medium">Tambah Kategori</span>
                </button>
              </div>
            </div>

            {loading ? (
              <div className="flex items-center justify-center py-12">
                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600" />
              </div>
            ) : filteredCategories.length === 0 ? (
              <div className="text-center py-12">
                <svg className="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p className="text-gray-500">
                  {showActiveOnly ? 'Belum ada kategori aktif' : 'Belum ada kategori nonaktif'}
                </p>
              </div>
            ) : (
              <div className="overflow-x-auto">
                <table className="w-full">
                  <thead className="bg-gray-50 border-b border-gray-200">
                    <tr>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                      <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                      <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                      <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                  </thead>
                  <tbody className="bg-white divide-y divide-gray-200">
                    {filteredCategories.map((category) => (
                      <tr key={category.id} className="hover:bg-gray-50 transition-colors">
                        <td className="px-6 py-4 whitespace-nowrap">
                          <span className="text-sm font-medium text-gray-900">{category.kode}</span>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <span className="text-sm text-gray-900">{category.nama}</span>
                        </td>
                        <td className="px-6 py-4">
                          <span className="text-sm text-gray-600">{category.deskripsi || '-'}</span>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap">
                          <div className="flex items-center justify-center gap-2">
                            <button
                              onClick={() => handleToggleActive(category)}
                              disabled={toggleLoading[category.id]}
                              className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed ${
                                category.is_active 
                                  ? 'bg-green-500 focus:ring-green-500' 
                                  : 'bg-red-500 focus:ring-red-500'
                              }`}
                            >
                              {toggleLoading[category.id] ? (
                                <div className="absolute inset-0 flex items-center justify-center">
                                  <div className="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full" />
                                </div>
                              ) : (
                                <span
                                  className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                                    category.is_active ? 'translate-x-6' : 'translate-x-1'
                                  }`}
                                />
                              )}
                            </button>
                            <span className={`text-xs font-medium ${category.is_active ? 'text-green-600' : 'text-red-600'}`}>
                              {category.is_active ? 'Aktif' : 'Nonaktif'}
                            </span>
                          </div>
                        </td>
                        <td className="px-6 py-4 whitespace-nowrap text-right">
                          <button 
                            onClick={() => openEditModal(category)} 
                            className="text-blue-600 hover:text-blue-800 font-medium"
                          >
                            Edit
                          </button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            )}
          </div>
        );

      case 'barang':
  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-200">
      <div className="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h3 className="text-lg font-semibold text-gray-800">Data Barang</h3>
        <button 
          onClick={openCreateBarangModal}
          className="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
        >
          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
          </svg>
          <span className="font-medium">Tambah Barang</span>
        </button>
      </div>

      {loading ? (
        <div className="flex items-center justify-center py-12">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600" />
        </div>
      ) : barangList.length === 0 ? (
        <div className="text-center py-12">
          <svg className="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <p className="text-gray-500 mb-4">Belum ada data barang</p>
          <button 
            onClick={openCreateBarangModal}
            className="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 4v16m8-8H4" />
            </svg>
            Tambah Barang Pertama
          </button>
        </div>
      ) : (
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {barangList.map((barang) => (
                <tr key={barang.barang_id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="text-sm font-medium text-gray-900">{barang.kode}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <div>
                      <div className="text-sm font-medium text-gray-900">{barang.nama}</div>
                      {barang.deskripsi && (
                        <div className="text-xs text-gray-500">{barang.deskripsi}</div>
                      )}
                    </div>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {barang.category_nama || '-'}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className={`text-sm font-semibold ${
                      barang.stok < barang.stok_min 
                        ? 'text-red-600' 
                        : barang.stok < barang.stok_min * 1.5 
                        ? 'text-yellow-600' 
                        : 'text-green-600'
                    }`}>
                      {barang.stok || 0}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className="text-sm text-gray-600">{barang.satuan}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                      barang.is_active 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-red-100 text-red-800'
                    }`}>
                      {barang.is_active ? 'Aktif' : 'Nonaktif'}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button 
  className="text-blue-600 hover:text-blue-800 mr-3"
  onClick={() => openEditBarangModal(barang)}
>
  Edit
</button>
                    <button 
  className="text-red-600 hover:text-red-800"
  onClick={() => handleDeleteBarang(barang)}
  disabled={toggleLoading[barang.barang_id]}
>
  {toggleLoading[barang.barang_id] ? (
    <span className="inline-flex items-center gap-1">
      <div className="animate-spin h-3 w-3 border-2 border-current border-t-transparent rounded-full" />
      Loading...
    </span>
  ) : (
    'Nonaktifkan'
  )}
</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );

      case 'transaksi':
  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-200">
      <div className="flex items-center justify-between px-6 py-4 border-b border-gray-200">
        <h3 className="text-lg font-semibold text-gray-800">Data Transaksi Stok</h3>
        <button 
          onClick={fetchTransaksi}
          className="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
        >
          <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>
          <span className="font-medium">Refresh</span>
        </button>
      </div>

      {loading ? (
        <div className="flex items-center justify-center py-12">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600" />
        </div>
      ) : transaksiList.length === 0 ? (
        <div className="text-center py-12">
          <svg className="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <p className="text-gray-500">Belum ada transaksi stok</p>
        </div>
      ) : (
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sumber</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sebelum</th>
                <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sesudah</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-200">
              {transaksiList.map((transaksi) => (
                <tr key={transaksi.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="text-sm font-medium text-gray-900">#{transaksi.id}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="text-sm text-gray-600">{formatDateTime(transaksi.created_at)}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getJenisTransaksiBadge(transaksi.jenis)}`}>
                      {transaksi.jenis}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="text-sm text-gray-900">{transaksi.sumber}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className={`text-sm font-semibold ${
                      transaksi.jenis === 'masuk' 
                        ? 'text-green-600' 
                        : transaksi.jenis === 'keluar'
                        ? 'text-red-600'
                        : 'text-orange-600'
                    }`}>
                      {transaksi.jenis === 'masuk' ? '+' : transaksi.jenis === 'keluar' ? '-' : '±'}
                      {transaksi.jumlah}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className="text-sm text-gray-600">{transaksi.stok_sebelum}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-center">
                    <span className="text-sm font-medium text-gray-900">{transaksi.stok_sesudah}</span>
                  </td>
                  <td className="px-6 py-4">
                    <span className="text-sm text-gray-600">{transaksi.keterangan || '-'}</span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-right">
                    <button 
                      onClick={() => fetchTransaksiDetail(transaksi.id)}
                      className="text-blue-600 hover:text-blue-800 font-medium text-sm"
                    >
                      Detail
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );

      case 'laporan':
  return (
    <div className="space-y-6">
      {/* Tab Switcher */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-2">
        <div className="flex gap-2">
          <button
            onClick={() => {
              setLaporanType('stok');
              fetchLaporanStok();
            }}
            className={`flex-1 px-4 py-3 rounded-lg font-medium transition-colors ${
              laporanType === 'stok'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-50 text-gray-600 hover:bg-gray-100'
            }`}
          >
            Laporan Stok
          </button>
          <button
            onClick={() => {
              setLaporanType('mutasi');
              fetchLaporanMutasi();
            }}
            className={`flex-1 px-4 py-3 rounded-lg font-medium transition-colors ${
              laporanType === 'mutasi'
                ? 'bg-blue-600 text-white'
                : 'bg-gray-50 text-gray-600 hover:bg-gray-100'
            }`}
          >
            Laporan Mutasi Stok
          </button>
        </div>
      </div>

      {/* Filter Section */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 className="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        
        {laporanType === 'stok' ? (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Cari Barang</label>
              <input
                type="text"
                value={filterLaporan.keyword}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, keyword: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="Nama atau kode barang"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Stok Minimum</label>
              <input
                type="number"
                min="0"
                value={filterLaporan.stok_min}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, stok_min: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="0"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Stok Maksimum</label>
              <input
                type="number"
                min="0"
                value={filterLaporan.stok_max}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, stok_max: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="1000"
              />
            </div>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Barang</label>
              <select
                value={filterLaporan.barang_id}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, barang_id: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              >
                <option value="">Semua Barang</option>
                {barangList.map((barang) => (
                  <option key={barang.barang_id} value={barang.barang_id}>
                    {barang.kode} - {barang.nama}
                  </option>
                ))}
              </select>
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Jenis Transaksi</label>
              <select
                value={filterLaporan.jenis}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, jenis: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              >
                <option value="">Semua Jenis</option>
                <option value="MASUK">Masuk</option>
                <option value="KELUAR">Keluar</option>
              </select>
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Sumber</label>
              <input
                type="text"
                maxLength={50}
                value={filterLaporan.sumber}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, sumber: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                placeholder="Sumber transaksi"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
              <input
                type="datetime-local"
                value={filterLaporan.tanggal_dari}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, tanggal_dari: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              />
            </div>
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
              <input
                type="datetime-local"
                value={filterLaporan.tanggal_sampai}
                onChange={(e) => setFilterLaporan({ ...filterLaporan, tanggal_sampai: e.target.value })}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
              />
            </div>
          </div>
        )}
        
        <div className="flex gap-3 mt-4">
          <button
            onClick={() => laporanType === 'stok' ? fetchLaporanStok() : fetchLaporanMutasi()}
            className="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Terapkan Filter
          </button>
          <button
            onClick={handleResetFilter}
            className="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors"
          >
            Reset
          </button>
        </div>
      </div>

      {/* Data Table */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-200">
        <div className="flex items-center justify-between px-6 py-4 border-b border-gray-200">
          <h3 className="text-lg font-semibold text-gray-800">
            {laporanType === 'stok' ? 'Data Laporan Stok' : 'Data Laporan Mutasi Stok'}
          </h3>
          <button
            onClick={() => laporanType === 'stok' ? fetchLaporanStok() : fetchLaporanMutasi()}
            className="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
          >
            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Refresh
          </button>
        </div>

        {loading ? (
          <div className="flex items-center justify-center py-12">
            <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600" />
          </div>
        ) : laporanType === 'stok' ? (
          laporanStok.length === 0 ? (
            <div className="text-center py-12">
              <svg className="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p className="text-gray-500">Tidak ada data laporan stok</p>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Min</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {laporanStok.map((item, index) => (
                    <tr key={index} className="hover:bg-gray-50 transition-colors">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="text-sm font-medium text-gray-900">{item.kode}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="text-sm text-gray-900">{item.nama}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="text-sm text-gray-600">{item.category_nama || '-'}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className={`text-sm font-semibold ${
                          item.stok < item.stok_min 
                            ? 'text-red-600' 
                            : item.stok < item.stok_min * 1.5 
                            ? 'text-yellow-600' 
                            : 'text-green-600'
                        }`}>
                          {item.stok || 0}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className="text-sm text-gray-600">{item.satuan}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className="text-sm text-gray-600">{item.stok_min}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                          item.stok < item.stok_min 
                            ? 'bg-red-100 text-red-800' 
                            : item.stok < item.stok_min * 1.5 
                            ? 'bg-yellow-100 text-yellow-800' 
                            : 'bg-green-100 text-green-800'
                        }`}>
                          {item.stok < item.stok_min ? 'Kritis' : item.stok < item.stok_min * 1.5 ? 'Rendah' : 'Normal'}
                        </span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )
        ) : (
          laporanMutasi.length === 0 ? (
            <div className="text-center py-12">
              <svg className="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p className="text-gray-500">Tidak ada data laporan mutasi stok</p>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead className="bg-gray-50 border-b border-gray-200">
                  <tr>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sumber</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sebelum</th>
                    <th className="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sesudah</th>
                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                  </tr>
                </thead>
                <tbody className="bg-white divide-y divide-gray-200">
                  {laporanMutasi.map((item, index) => (
                    <tr key={index} className="hover:bg-gray-50 transition-colors">
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="text-sm text-gray-600">{formatDateTime(item.tanggal)}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <div className="text-sm font-medium text-gray-900">{item.barang_nama}</div>
                        <div className="text-xs text-gray-500">{item.barang_kode}</div>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                          item.jenis === 'MASUK' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                        }`}>
                          {item.jenis}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap">
                        <span className="text-sm text-gray-900">{item.sumber}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className={`text-sm font-semibold ${
                          item.jenis === 'MASUK' ? 'text-green-600' : 'text-red-600'
                        }`}>
                          {item.jenis === 'MASUK' ? '+' : '-'}{item.jumlah}
                        </span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className="text-sm text-gray-600">{item.stok_sebelum}</span>
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-center">
                        <span className="text-sm font-medium text-gray-900">{item.stok_sesudah}</span>
                      </td>
                      <td className="px-6 py-4">
                        <span className="text-sm text-gray-600">{item.keterangan || '-'}</span>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )
        )}
      </div>
    </div>
  );
      default:
        return null;
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 flex">
      {/* Sidebar */}
      <aside className={`${sidebarOpen ? 'translate-x-0' : '-translate-x-full'} lg:translate-x-0 fixed lg:static inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-slate-900 via-blue-900 to-slate-800 text-white transition-transform duration-300 ease-in-out`}>
        <div className="flex flex-col h-full">
          <div className="flex items-center justify-between px-6 py-6 border-b border-blue-800/50">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
              <div>
                <h1 className="font-bold text-sm">PT Rizky Badai</h1>
                <p className="text-xs text-blue-300">Inventaris</p>
              </div>
            </div>
            <button onClick={() => setSidebarOpen(false)} className="lg:hidden text-white">
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <nav className="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <button 
              onClick={() => setActiveSection('dashboard')}
              className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${
                activeSection === 'dashboard' 
                  ? 'bg-blue-600/20 text-white' 
                  : 'hover:bg-blue-600/10 text-blue-200 hover:text-white'
              }`}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <span className="font-medium">Dashboard</span>
            </button>
            
            <button 
              onClick={() => setActiveSection('kategori')}
              className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${
                activeSection === 'kategori' 
                  ? 'bg-blue-600/20 text-white' 
                  : 'hover:bg-blue-600/10 text-blue-200 hover:text-white'
              }`}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <span>Kategori</span>
            </button>
            
            <button 
              onClick={() => setActiveSection('barang')}
              className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${
                activeSection === 'barang' 
                  ? 'bg-blue-600/20 text-white' 
                  : 'hover:bg-blue-600/10 text-blue-200 hover:text-white'
              }`}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
              <span>Barang</span>
            </button>
            
            <button 
              onClick={() => setActiveSection('transaksi')}
              className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${
                activeSection === 'transaksi' 
                  ? 'bg-blue-600/20 text-white' 
                  : 'hover:bg-blue-600/10 text-blue-200 hover:text-white'
              }`}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span>Transaksi</span>
            </button>
            
            <button 
              onClick={() => setActiveSection('laporan')}
              className={`w-full flex items-center gap-3 px-4 py-3 rounded-lg transition-colors ${
                activeSection === 'laporan' 
                  ? 'bg-blue-600/20 text-white' 
                  : 'hover:bg-blue-600/10 text-blue-200 hover:text-white'
              }`}
            >
              <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Laporan</span>
            </button>
          </nav>

          <div className="px-4 py-4 border-t border-blue-800/50">
            <div className="flex items-center gap-3 px-4 py-3 bg-blue-600/10 rounded-lg">
              <div className="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                <span className="text-sm font-bold">{userData?.user?.username?.charAt(0).toUpperCase() || 'U'}</span>
              </div>
              <div className="flex-1 min-w-0">
                <p className="text-sm font-medium truncate">{userData?.user?.employee?.nama || 'User'}</p>
                <p className="text-xs text-blue-300 truncate">{userData?.user?.role?.name || 'Role'}</p>
              </div>
            </div>
            <button onClick={handleLogout} className="w-full mt-3 flex items-center justify-center gap-2 px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-300 hover:text-red-200 rounded-lg transition-colors">
              <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
              <span className="text-sm font-medium">Logout</span>
            </button>
          </div>
        </div>
      </aside>

      {sidebarOpen && (
        <div onClick={() => setSidebarOpen(false)} className="lg:hidden fixed inset-0 bg-black/50 z-40" />
      )}

      <div className="flex-1 flex flex-col min-w-0">
        <header className="bg-white shadow-sm sticky top-0 z-30">
          <div className="flex items-center justify-between px-4 lg:px-8 py-4">
            <div className="flex items-center gap-4">
              <button onClick={() => setSidebarOpen(true)} className="lg:hidden text-gray-600">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
              <div>
                <h2 className="text-xl lg:text-2xl font-bold text-gray-800">
                  {activeSection === 'dashboard' ? 'Dashboard' : 
                   activeSection === 'kategori' ? 'Kategori' :
                   activeSection === 'barang' ? 'Barang' :
                   activeSection === 'transaksi' ? 'Transaksi' :
                   activeSection === 'laporan' ? 'Laporan' : 'Dashboard'}
                </h2>
                <p className="text-sm text-gray-600 hidden sm:block">Kelola data inventaris gudang</p>
              </div>
            </div>
            <div className="flex items-center gap-3">
              <button className="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg className="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
              </button>
            </div>
          </div>
        </header>

        <main className="flex-1 p-4 lg:p-8 overflow-y-auto">
          {renderContent()}
        </main>
      </div>

      {/* Modal */}
      {/* Modal Delete Confirmation */}
      {showDeleteModal && (
        <div className="fixed inset-0 z-50 overflow-y-auto">
          <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div onClick={() => {
              setShowDeleteModal(false);
              setDeleteReason('');
              setBarangToDelete(null);
            }} className="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" />
            <div className="relative inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
              <div className="bg-white px-6 pt-6 pb-4">
                <div className="flex items-center gap-3 mb-4">
                  <div className="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg className="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  <div>
                    <h3 className="text-lg font-bold text-gray-900">Nonaktifkan Barang</h3>
                    <p className="text-sm text-gray-600 mt-1">
                      Anda akan menonaktifkan: <span className="font-semibold">{barangToDelete?.nama}</span>
                    </p>
                  </div>
                </div>
                
                <div className="mt-4">
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penonaktifan <span className="text-red-500">*</span>
                  </label>
                  <select
                    required
                    value={deleteReason}
                    onChange={(e) => setDeleteReason(e.target.value)}
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                  >
                    <option value="">-- Pilih Alasan --</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                    <option value="obsolete">Obsolete</option>
                    <option value="expired">Expired</option>
                    <option value="salah_input">Salah Input</option>
                  </select>
                </div>

                <div className="bg-amber-50 border border-amber-200 rounded-lg p-3 mt-4">
                  <p className="text-sm text-amber-800">
                    <strong>Perhatian:</strong> Barang yang dinonaktifkan tidak akan dapat digunakan dalam transaksi baru.
                  </p>
                </div>
              </div>
              
              <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                <button
                  type="button"
                  onClick={() => {
                    setShowDeleteModal(false);
                    setDeleteReason('');
                    setBarangToDelete(null);
                  }}
                  className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                >
                  Batal
                </button>
                <button
                  onClick={confirmDeleteBarang}
                  disabled={!deleteReason}
                  className="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  Nonaktifkan
                </button>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Modal Detail Transaksi */}
{showTransaksiDetail && selectedTransaksi && (
  <div className="fixed inset-0 z-50 overflow-y-auto">
    <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
      <div onClick={() => setShowTransaksiDetail(false)} className="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" />
      <div className="relative inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
        <div className="bg-white px-6 pt-6 pb-4">
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-xl font-bold text-gray-900">Detail Transaksi Stok</h3>
            <button
              onClick={() => setShowTransaksiDetail(false)}
              className="text-gray-400 hover:text-gray-600"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div className="space-y-4">
            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">ID Transaksi</label>
                <p className="text-base font-semibold text-gray-900">#{selectedTransaksi.id}</p>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Tanggal</label>
                <p className="text-base text-gray-900">{formatDateTime(selectedTransaksi.created_at)}</p>
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Jenis Transaksi</label>
                <span className={`inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${getJenisTransaksiBadge(selectedTransaksi.jenis)}`}>
                  {selectedTransaksi.jenis}
                </span>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Sumber</label>
                <p className="text-base text-gray-900">{selectedTransaksi.sumber}</p>
              </div>
            </div>

            <div className="grid grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Jumlah</label>
                <p className={`text-xl font-bold ${
                  selectedTransaksi.jenis === 'masuk' 
                    ? 'text-green-600' 
                    : selectedTransaksi.jenis === 'keluar'
                    ? 'text-red-600'
                    : 'text-orange-600'
                }`}>
                  {selectedTransaksi.jenis === 'masuk' ? '+' : selectedTransaksi.jenis === 'keluar' ? '-' : '±'}
                  {selectedTransaksi.jumlah}
                </p>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Stok Sebelum</label>
                <p className="text-xl font-bold text-gray-700">{selectedTransaksi.stok_sebelum}</p>
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Stok Sesudah</label>
                <p className="text-xl font-bold text-gray-900">{selectedTransaksi.stok_sesudah}</p>
              </div>
            </div>

            {selectedTransaksi.keterangan && (
              <div>
                <label className="block text-sm font-medium text-gray-500 mb-1">Keterangan</label>
                <p className="text-base text-gray-900 bg-gray-50 p-3 rounded-lg">{selectedTransaksi.keterangan}</p>
              </div>
            )}

            <div className="grid grid-cols-2 gap-4">
              {selectedTransaksi.barang_id && (
                <div>
                  <label className="block text-sm font-medium text-gray-500 mb-1">ID Barang</label>
                  <p className="text-base text-gray-900">{selectedTransaksi.barang_id}</p>
                </div>
              )}
              {selectedTransaksi.user_id && (
                <div>
                  <label className="block text-sm font-medium text-gray-500 mb-1">User ID</label>
                  <p className="text-base text-gray-900">{selectedTransaksi.user_id}</p>
                </div>
              )}
            </div>

            {(selectedTransaksi.dispatch_id || selectedTransaksi.receiving_id || selectedTransaksi.adjustment_id) && (
              <div className="border-t pt-4">
                <label className="block text-sm font-medium text-gray-500 mb-2">Referensi</label>
                <div className="space-y-2">
                  {selectedTransaksi.dispatch_id && (
                    <p className="text-sm text-gray-600">Dispatch ID: <span className="font-medium">{selectedTransaksi.dispatch_id}</span></p>
                  )}
                  {selectedTransaksi.receiving_id && (
                    <p className="text-sm text-gray-600">Receiving ID: <span className="font-medium">{selectedTransaksi.receiving_id}</span></p>
                  )}
                  {selectedTransaksi.adjustment_id && (
                    <p className="text-sm text-gray-600">Adjustment ID: <span className="font-medium">{selectedTransaksi.adjustment_id}</span></p>
                  )}
                </div>
              </div>
            )}
          </div>
        </div>
        
        <div className="bg-gray-50 px-6 py-4 flex justify-end">
          <button
            onClick={() => setShowTransaksiDetail(false)}
            className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
)}

      {showModal && (
        <div className="fixed inset-0 z-50 overflow-y-auto">
          <div className="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div onClick={() => setShowModal(false)} className="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" />
            <div className="relative inline-block bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
              {modalType === 'category' ? (
                <form onSubmit={modalMode === 'create' ? handleCreate : handleUpdate}>
                  <div className="bg-white px-6 pt-6 pb-4">
                    <h3 className="text-xl font-bold text-gray-900 mb-6">
                      {modalMode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'}
                    </h3>
                    <div className="space-y-4">
                      {modalMode === 'create' && (
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">Kode</label>
                          <input
                            type="text"
                            required
                            maxLength={50}
                            value={formData.kode}
                            onChange={(e) => setFormData({ ...formData, kode: e.target.value })}
                            className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                            placeholder="Masukkan kode kategori"
                          />
                        </div>
                      )}
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                        <input
                          type="text"
                          required
                          maxLength={100}
                          value={formData.nama}
                          onChange={(e) => setFormData({ ...formData, nama: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                          placeholder="Masukkan nama kategori"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea
                          value={formData.deskripsi}
                          onChange={(e) => setFormData({ ...formData, deskripsi: e.target.value })}
                          rows={3}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                          placeholder="Masukkan deskripsi (opsional)"
                        />
                      </div>
                    </div>
                  </div>
                  <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                      type="button"
                      onClick={() => setShowModal(false)}
                      className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                      Batal
                    </button>
                    <button
                      type="submit"
                      className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium"
                    >
                      {modalMode === 'create' ? 'Tambah' : 'Simpan'}
                    </button>
                  </div>
                </form>
              ) : modalType === 'barang' ? (
  <form onSubmit={modalMode === 'create' ? handleCreateBarang : handleUpdateBarang}>
                  <div className="bg-white px-6 pt-6 pb-4">
<h3 className="text-xl font-bold text-gray-900 mb-6">
  {modalMode === 'create' ? 'Tambah Barang Baru' : 'Edit Barang'}
</h3>                    <div className="space-y-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Kode Barang <span className="text-red-500">*</span>
                        </label>
                        <input
  type="text"
  required
  maxLength={50}
  value={barangForm.kode}
  onChange={(e) => setBarangForm({ ...barangForm, kode: e.target.value })}
  disabled={modalMode === 'edit'}
  className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none disabled:bg-gray-100 disabled:cursor-not-allowed"
  placeholder="Contoh: BRG001"
/>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Nama Barang <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="text"
                          required
                          maxLength={100}
                          value={barangForm.nama}
                          onChange={(e) => setBarangForm({ ...barangForm, nama: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Masukkan nama barang"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Kategori <span className="text-red-500">*</span>
                        </label>
                        <select
                          required
                          value={barangForm.category_id}
                          onChange={(e) => setBarangForm({ ...barangForm, category_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Kategori --</option>
                          {categories.filter(cat => cat.is_active).map((category) => (
                            <option key={category.id} value={category.id}>
                              {category.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div className="grid grid-cols-1 gap-4"> {/* UBAH dari grid-cols-2 */}
                        <div>
                          <label className="block text-sm font-medium text-gray-700 mb-2">
                            Satuan <span className="text-red-500">*</span>
                          </label>
                          <input
                            type="text"
                            required
                            maxLength={20}
                            value={barangForm.satuan}
                            onChange={(e) => setBarangForm({ ...barangForm, satuan: e.target.value })}
                            className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            placeholder="Contoh: pcs, box, kg"
                          />
                        </div>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Stok Minimum <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="number"
                          required
                          min="0"
                          value={barangForm.stok_min}
                          onChange={(e) => setBarangForm({ ...barangForm, stok_min: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Minimal stok untuk alert"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea
                          value={barangForm.deskripsi}
                          onChange={(e) => setBarangForm({ ...barangForm, deskripsi: e.target.value })}
                          rows={3}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Deskripsi barang (opsional)"
                        />
                      </div>
                    </div>
                  </div>
                  <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                      type="button"
                      onClick={() => setShowModal(false)}
                      className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                      Batal
                    </button>
                    <button
  type="submit"
  className="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium"
>
  {modalMode === 'create' ? 'Tambah Barang' : 'Simpan Perubahan'}
</button>
                  </div>
                </form>
              ) : modalType === 'receiving' ? (
                <form onSubmit={handleReceiving}>
                  <div className="bg-white px-6 pt-6 pb-4">
                    <h3 className="text-xl font-bold text-gray-900 mb-6">Penerimaan Barang</h3>
                    <div className="space-y-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                        <select
                          required
                          value={receivingForm.supplier_id}
                          onChange={(e) => setReceivingForm({ ...receivingForm, supplier_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Supplier --</option>
                          {supplierList.map((supplier) => (
                            <option key={supplier.id} value={supplier.id}>
                              {supplier.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Warehouse</label>
                        <select
                          required
                          value={receivingForm.warehouse_id}
                          onChange={(e) => setReceivingForm({ ...receivingForm, warehouse_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Warehouse --</option>
                          {warehouseList.map((warehouse) => (
                            <option key={warehouse.id} value={warehouse.id}>
                              {warehouse.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <select
                          required
                          value={receivingForm.location_id}
                          onChange={(e) => setReceivingForm({ ...receivingForm, location_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Location --</option>
                          {locationList.map((location) => (
                            <option key={location.id} value={location.id}>
                              {location.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Pilih Barang</label>
                        <select
                          required
                          value={receivingForm.barang_id}
                          onChange={(e) => setReceivingForm({ ...receivingForm, barang_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Barang --</option>
                          {barangList.map((barang) => (
                            <option key={barang.barang_id} value={barang.barang_id}>
                              {barang.kode} - {barang.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input
                          type="number"
                          required
                          min="1"
                          value={receivingForm.jumlah}
                          onChange={(e) => setReceivingForm({ ...receivingForm, jumlah: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea
                          value={receivingForm.keterangan}
                          onChange={(e) => setReceivingForm({ ...receivingForm, keterangan: e.target.value })}
                          rows={3}
                          maxLength={255}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Keterangan (opsional)"
                        />
                      </div>
                    </div>
                  </div>
                  <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                      type="button"
                      onClick={() => setShowModal(false)}
                      className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                      Batal
                    </button>
                    <button
                      type="submit"
                      className="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium"
                    >
                      Simpan
                    </button>
                  </div>
                </form>
              ) : modalType === 'dispatch' ? (
                <form onSubmit={handleDispatch}>
                  <div className="bg-white px-6 pt-6 pb-4">
                    <h3 className="text-xl font-bold text-gray-900 mb-6">Dispatch Barang</h3>
                    <div className="space-y-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Pilih Barang</label>
                        <select
                          required
                          value={dispatchForm.barang_id}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, barang_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Barang --</option>
                          {barangList.map((barang) => (
                            <option key={barang.barang_id} value={barang.barang_id}>
                              {barang.kode} - {barang.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Warehouse</label>
                        <select
                          required
                          value={dispatchForm.warehouse_id}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, warehouse_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Warehouse --</option>
                          {warehouseList.map((warehouse) => (
                            <option key={warehouse.id} value={warehouse.id}>
                              {warehouse.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <select
                          required
                          value={dispatchForm.location_id}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, location_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Location --</option>
                          {locationList.map((location) => (
                            <option key={location.id} value={location.id}>
                              {location.nama}
                            </option>
                          ))}
                        </select>
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input
                          type="number"
                          required
                          min="1"
                          value={dispatchForm.jumlah}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, jumlah: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Tujuan</label>
                        <input
                          type="text"
                          required
                          value={dispatchForm.tujuan}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, tujuan: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Tujuan pengiriman"
                        />
                      </div>
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea
                          value={dispatchForm.keterangan}
                          onChange={(e) => setDispatchForm({ ...dispatchForm, keterangan: e.target.value })}
                          rows={3}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Keterangan (opsional)"
                        />
                      </div>
                    </div>
                  </div>
                  <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                      type="button"
                      onClick={() => setShowModal(false)}
                      className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                      Batal
                    </button>
                    <button
                      type="submit"
                      className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium"
                    >
                      Kirim
                    </button>
                  </div>
                </form>
              ) : modalType === 'adjustment' ? (
                <form onSubmit={handleAdjustment}>
                  <div className="bg-white px-6 pt-6 pb-4">
                    <h3 className="text-xl font-bold text-gray-900 mb-6">Penyesuaian Stok</h3>
                    <div className="space-y-4">
                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">Pilih Barang</label>
                        <select
                          required
                          value={adjustmentForm.barang_id}
                          onChange={(e) => setAdjustmentForm({ ...adjustmentForm, barang_id: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        >
                          <option value="">-- Pilih Barang --</option>
                          {barangList.map((barang) => (
                            <option key={barang.barang_id} value={barang.barang_id}>
                              {barang.kode} - {barang.nama} (Stok Sistem: {barang.stok})
                            </option>
                          ))}
                        </select>
                      </div>

                      {selectedBarangForAdjustment  && (
                        <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                          <div className="flex items-start gap-3">
                            <div className="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                              <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            </div>
                            <div className="flex-1">
                              <p className="text-sm font-medium text-blue-900">Stok Sistem Saat Ini</p>
                              <p className="text-2xl font-bold text-blue-700 mt-1">{selectedBarangForAdjustment.stok} unit</p>
  <p className="text-xs text-blue-600 mt-1">
    {selectedBarangForAdjustment.kode} - {selectedBarangForAdjustment.nama}
  </p>
                            </div>
                          </div>
                        </div>
                      )}

                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Stok Fisik <span className="text-red-500">*</span>
                        </label>
                        <input
                          type="number"
                          required
                          min="0"
                          value={adjustmentForm.stok_fisik}
                          onChange={(e) => setAdjustmentForm({ ...adjustmentForm, stok_fisik: e.target.value })}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Masukkan jumlah stok fisik yang dihitung"
                        />
                        <p className="text-xs text-gray-500 mt-1">
                          Masukkan jumlah stok fisik hasil perhitungan di gudang
                        </p>
                      </div>

                      {selectedBarangForAdjustment  && adjustmentForm.stok_fisik !== '' && (
                        <div className={`rounded-lg p-4 ${
                          parseInt(adjustmentForm.stok_fisik) === selectedBarangForAdjustment.stok 
                            ? 'bg-green-50 border border-green-200' 
                            : parseInt(adjustmentForm.stok_fisik) > selectedBarangForAdjustment.stok
                            ? 'bg-yellow-50 border border-yellow-200'
                            : 'bg-red-50 border border-red-200'
                        }`}>
                          <div className="flex items-center gap-2 mb-2">
                            <svg className={`w-5 h-5 ${
                              parseInt(adjustmentForm.stok_fisik) === selectedBarang.stok 
                                ? 'text-green-600' 
                                : parseInt(adjustmentForm.stok_fisik) > selectedBarang.stok
                                ? 'text-yellow-600'
                                : 'text-red-600'
                            }`} fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p className={`text-sm font-medium ${
                              parseInt(adjustmentForm.stok_fisik) === selectedBarang.stok 
                                ? 'text-green-900' 
                                : parseInt(adjustmentForm.stok_fisik) > selectedBarang.stok
                                ? 'text-yellow-900'
                                : 'text-red-900'
                            }`}>
                              Selisih Stok
                            </p>
                          </div>
                          <p className={`text-2xl font-bold ${
                            parseInt(adjustmentForm.stok_fisik) === selectedBarang.stok 
                              ? 'text-green-700' 
                              : parseInt(adjustmentForm.stok_fisik) > selectedBarang.stok
                              ? 'text-yellow-700'
                              : 'text-red-700'
                          }`}>
                            {parseInt(adjustmentForm.stok_fisik) - selectedBarang.stok > 0 ? '+' : ''}
                            {parseInt(adjustmentForm.stok_fisik) - selectedBarang.stok} unit
                          </p>
                          <p className={`text-xs mt-1 ${
                            parseInt(adjustmentForm.stok_fisik) === selectedBarang.stok 
                              ? 'text-green-600' 
                              : parseInt(adjustmentForm.stok_fisik) > selectedBarang.stok
                              ? 'text-yellow-600'
                              : 'text-red-600'
                          }`}>
                            {parseInt(adjustmentForm.stok_fisik) === selectedBarang.stok 
                              ? 'Stok sistem dan fisik sudah sesuai' 
                              : parseInt(adjustmentForm.stok_fisik) > selectedBarang.stok
                              ? 'Stok fisik lebih banyak dari sistem (kelebihan)'
                              : 'Stok fisik lebih sedikit dari sistem (kekurangan)'}
                          </p>
                        </div>
                      )}

                      <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                          Alasan Penyesuaian <span className="text-red-500">*</span>
                        </label>
                        <textarea
                          required
                          minLength={10}
                          maxLength={255}
                          value={adjustmentForm.alasan}
                          onChange={(e) => setAdjustmentForm({ ...adjustmentForm, alasan: e.target.value })}
                          rows={4}
                          className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                          placeholder="Jelaskan alasan penyesuaian stok (minimal 10 karakter)"
                        />
                        <p className="text-xs text-gray-500 mt-1">
                          {adjustmentForm.alasan.length}/255 karakter (minimal 10 karakter)
                        </p>
                      </div>

                      <div className="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <div className="flex gap-3">
                          <svg className="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                          </svg>
                          <div>
                            <p className="text-sm font-medium text-amber-900">Perhatian</p>
                            <p className="text-xs text-amber-700 mt-1">
                              Pastikan perhitungan stok fisik sudah benar. Penyesuaian ini akan diajukan untuk persetujuan.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                    <button
                      type="button"
                      onClick={() => setShowModal(false)}
                      className="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                      Batal
                    </button>
                    <button
                      type="submit"
                      disabled={!adjustmentForm.barang_id || !adjustmentForm.alasan || adjustmentForm.alasan.length < 10}
                      className="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      Ajukan Penyesuaian
                    </button>
                  </div>
                </form>
              ) : null}
            </div>
          </div>
        </div>
      )}
    </div>
  );
}