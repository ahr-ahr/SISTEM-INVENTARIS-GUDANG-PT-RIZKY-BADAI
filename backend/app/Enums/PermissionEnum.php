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
    case ADJUST_STOK = 'adjust_stok';
    case APPROVE_STOK = 'approve_stok';
    case REJECT_STOK  = 'reject_stok';
    case VIEW_STOK    = 'view_stok';
    case CREATE_TRANSFER  = 'create_transfer';
    case APPROVE_TRANSFER = 'approve_transfer';
    case REJECT_TRANSFER  = 'reject_transfer';
    case VIEW_TRANSFER    = 'view_transfer';

    // =====================
    // TIMBANG & QC
    // =====================
    case REKAP_TIMBANG = 'rekap_timbang';
    case QC_CHECK     = 'qc_check';

    // =====================
    // LAPORAN
    // =====================
    case VIEW_LAPORAN = 'view_laporan';

    // =====================
    // RECEIVING (Petugas Bongkar Barang)
    // =====================
    case RECEIVING_CONFIRM_UNLOADED = 'receiving_confirm_unloaded';
    case RECEIVING_MARK_STAGED     = 'receiving_mark_staged';

    // =====================
    // QC (SCS)
    // =====================
    case VIEW_QC_REPORT   = 'view_qc_report';
    case DECIDE_QC_REJECT = 'decide_qc_reject';
}
