<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Logo Portal IT">
</p>

<h1 align="center">Portal IT: Gestión de Inventario, Licencias y Accesos</h1>

<p align="center">
  <strong>Solución integral para el control de activos tecnológicos y recursos de usuario.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-4E56A6?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/NativePHP-4050fb?style=for-the-badge&logo=electron&logoColor=white" alt="NativePHP">
</p>

---

## 🚀 Sobre el Proyecto

**Portal IT** es una herramienta interna diseñada para centralizar la gestión de hardware, software y accesos. Permite a los administradores de sistemas llevar un control exhaustivo de los equipos distribuidos por la empresa, gestionar las asignaciones dinámicamente y monitorizar las configuraciones de teletrabajo.

Desarrollado con el ecosistema más moderno de PHP, ofrece una experiencia de usuario fluida y reactiva tanto en entorno web como en aplicación de escritorio gracias a **NativePHP**.

## ✨ Características Principales

| Módulo | Descripción |
| :--- | :--- |
| 🖥️ **Gestión de Equipos** | Inventario detallado (Marca, Modelo, Serial, MAC, Tipo de Conexión, etc.). |
| 👥 **Asignaciones** | Control de quién posee cada activo y su ubicación (Centro, Planta, Zona). |
| 🏠 **Teletrabajo** | Gestión de accesos y equipos configurados para trabajo remoto. |
| 📊 **Importación/Exportación** | Integración total con Excel para carga masiva y reportes detallados. |
| 📦 **App de Escritorio** | Ejecución nativa en Windows mediante Electron (NativePHP). |

## 🛠️ Stack Tecnológico

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend Interactivo**: [Livewire 3](https://livewire.laravel.com)
- **Estilos**: [Tailwind CSS](https://tailwindcss.com)
- **Desktop Wrapper**: [NativePHP](https://nativephp.com) (Electron)
- **Excel Engine**: [Laravel Excel](https://docs.laravel-excel.com/)
- **Build Tool**: [Vite](https://vitejs.dev)

## 📦 Instalación y Configuración

Siga estos pasos para configurar el proyecto localmente:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/jmelote2909/Inventario_Licencias_Y_Accesos.git
   cd Inventario_Licencias_Y_Accesos
   ```

2. **Instalar dependencias de PHP y Node:**
   ```bash
   composer install
   npm install
   ```

3. **Configurar el entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Ejecutar migraciones:**
   ```bash
   php artisan migrate --seed
   ```

5. **Lanzar el servidor de desarrollo:**
   ```bash
   npm run dev
   ```

---

## 💻 Versión de Escritorio

Para ejecutar o compilar la versión de escritorio basada en Electron:

```bash
# Ejecutar en modo desarrollo
php artisan native:serve

# Compilar instalador (.exe)
php artisan native:build
```

---

## ✍️ Autor

- **Jesús Meléndez Oteros** - *Desarrollo Inicial* - [@jmelote2909](https://github.com/jmelote2909)

---
<p align="center">Desarrollado con ❤️ para el Departamento de IT</p>
