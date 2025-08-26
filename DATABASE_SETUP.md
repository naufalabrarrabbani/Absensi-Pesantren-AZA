# 🗄️ Database Setup Guide

## Database Configuration

1. **Copy configuration template:**
   ```bash
   cp include/koneksi.php.example include/koneksi.php
   cp app/include/koneksi.php.example app/include/koneksi.php
   ```

2. **Update database credentials in both files:**
   - `include/koneksi.php`
   - `app/include/koneksi.php`

3. **Example configuration:**
   ```php
   $host = 'localhost';
   $username = 'root';
   $password = 'your_password';
   $database = 'db_absensi';
   ```

## ⚠️ Security Notes

- ❌ **NEVER** commit `koneksi.php` files to version control
- ✅ **ALWAYS** use `koneksi.php.example` as template
- 🔒 Keep database credentials secure
- 📝 Use `.env` files for production environments

## Database Schema

Import the database schema from:
- `update_absensi_table.sql` (if available)
- Or create tables manually based on the application structure

## Required Tables

The application expects these tables:
- `aplikasi` - Application settings
- `karyawan` - Student data
- `guru` - Teacher data  
- `absensi` - Attendance records
- `absensi_guru` - Teacher attendance
- `admin` - Admin users
- `area` - Location areas

## Setup Steps

1. Create MySQL database named `db_absensi`
2. Import SQL schema
3. Copy and configure `koneksi.php` files
4. Update database credentials
5. Test connection by accessing the application
