
---

# Modulares Role‑ & Permission‑basiertes Admin‑Dashboard  
Ein professionelles, modular aufgebautes Laravel‑Backend‑System mit vollständigem Activity‑Logging, Analytics‑Dashboard und sauberer Architektur.

---

## 🚀 Features

### 🔐 Benutzer‑ & Rollenverwaltung
- Benutzerverwaltung (CRUD)  
- Rollenverwaltung (CRUD)  
- Berechtigungsverwaltung (CRUD)  
- Zugriffskontrolle über Policies & Middleware  
- REST API (Laravel Sanctum)

### 📊 Activity Logs (vollständig implementiert)
- Automatisches Logging aller Aktionen (create / update / delete)  
- Speicherung von:
  - Benutzer  
  - Modell & Modell‑ID  
  - IP‑Adresse  
  - URL  
  - HTTP‑Methode  
  - User Agent  
  - **Old Values / New Values (Diff)**  
- Diff‑Ansicht in Modal‑Fenstern  
- Filter nach Benutzer, Modell, Aktion, Datum  
- Volltextsuche  
- CSV‑Export  
- Pagination  

### 📈 Analytics Dashboard
- Tagesbasierte Aktivitätsstatistik  
- Grafische Darstellung der Log‑Einträge  
- Übersicht über Systemaktivität  
- Erweiterbare Architektur für weitere Charts  

### 🎨 UI / UX
- Modernes Admin‑UI basierend auf Laravel Breeze  
- Tailwind CSS  
- Responsive Layout  
- Klare, intuitive Navigation  

---

## 🛠 Tech Stack

- **PHP 8.3**  
- **Laravel 12.49**  
- **SQLite**  
- **Laravel Breeze**  
- **Tailwind CSS**  
- **Laravel Sanctum**  
- **VSCode**

---

## 📦 Installation

### 1. Repository klonen
```bash
git clone <repo-url>
cd admin-dashboard
```

### 2. Abhängigkeiten installieren
```bash
composer install
npm install
```

### 3. Environment-Datei erstellen
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Datenbank vorbereiten (SQLite)
```bash
touch database/database.sqlite
```

### 5. Migrationen + Seeder ausführen
```bash
php artisan migrate:fresh --seed
```

### 6. Development Server starten
```bash
npm run dev
php artisan serve
```

---

## 🔐 Default Login Credentials

### Admin
```
Email: admin@example.com
Passwort: 123456
```

### User
```
Email: user@example.com
Passwort: password
```

---

## 📚 API Endpoints (Auszug)

| Methode | Endpoint | Beschreibung |
|--------|----------|--------------|
| GET | /api/users | Liste aller Benutzer |
| GET | /api/users/{id} | Einzelner Benutzer |
| POST | /api/users | Benutzer erstellen |
| PUT | /api/users/{id} | Benutzer aktualisieren |
| DELETE | /api/users/{id} | Benutzer löschen |

Authentifizierung über **Laravel Sanctum**.

---

## 🧱 Projektstruktur

```
app/
 ├── Http/
 │    ├── Controllers/Admin
 │    ├── Middleware
 │    └── Requests
 ├── Models
 ├── Policies
 └── Traits (Activity Logging)
resources/
 ├── views/admin
 └── css/js (Breeze)
database/
 ├── migrations
 └── seeders
```

---

## 🔒 Rollen & Berechtigungen

### Rollen:
- **Admin** – Vollzugriff  
- **User** – Eingeschränkter Zugriff  

### Berechtigungen:
- user.create  
- user.update  
- user.delete  
- role.manage  
- permission.manage  

---

## 📊 Activity Log – Details

### Gespeicherte Daten:
- user_id  
- action (create/update/delete)  
- model  
- model_id  
- ip_address  
- url  
- method  
- user_agent  
- **old_values / new_values (JSON)**  

### Diff‑Ansicht:
- Zeigt Änderungen pro Feld  
- Old vs. New  
- Modal‑Fenster mit sauberem Layout  

---

## 📈 Analytics Dashboard

- Gruppierung der Logs nach Datum  
- Anzeige der täglichen Aktivität  
- Grundlage für erweiterbare Systemstatistiken  

---

## 📝 License

–

---

## 👤 Autor

Studentenprojekt (PHP / Laravel Fallstudie)

---

