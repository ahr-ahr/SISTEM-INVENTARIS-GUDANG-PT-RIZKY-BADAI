<?php

namespace App\Enums;

enum PermissionEnum: string
{
    // =====================
    // SYSTEM
    // =====================
    case MANAGE_SYSTEM      = 'manage_system';
    case MANAGE_USERS       = 'manage_users';
    case MANAGE_ROLES       = 'manage_roles';
    case MANAGE_PERMISSIONS = 'manage_permissions';

    // =====================
    // MASTER BARANG
    // =====================
    case VIEW_BARANG   = 'view_barang';
    case CREATE_BARANG = 'create_barang';
    case UPDATE_BARANG = 'update_barang';
    case DELETE_BARANG = 'delete_barang';

    // =====================
    // STOK & GUDANG
    // =====================
    case BARANG_MASUK  = 'barang_masuk';
    case BARANG_KELUAR = 'barang_keluar';
    case APPROVE_STOK = 'approve_stok';

    // =====================
    // TIMBANG & QC
    // =====================
    case REKAP_TIMBANG = 'rekap_timbang';
    case QC_CHECK     = 'qc_check';

    // =====================
    // LAPORAN
    // =====================
    case VIEW_LAPORAN = 'view_laporan';
}
