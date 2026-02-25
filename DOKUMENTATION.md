
---

# 📘 **Dokumentation – Modulares Role‑ & Permission‑basiertes Admin‑Dashboard**  
**Autor:** Zyma Natalia  
**Kurs:** PHP / Laravel Fallstudie  
**Datum:** 23.02.2026  

---

# 1. Einleitung

## 1.1 Projektübersicht  
Dieses Projekt ist ein **modulares Laravel‑Admin‑Dashboard**, das eine vollständige Benutzer‑, Rollen‑ und Berechtigungsverwaltung bereitstellt.  
Ein zentrales Element des Systems ist das **Activity Logging**, das alle Aktionen im Backend automatisch protokolliert – inklusive **Old/New‑Werten und Diff‑Analyse**.  

Zusätzlich bietet das Projekt:

- ein **Analytics‑Dashboard** zur Visualisierung der Systemaktivität  
- eine **REST‑API** für externe Clients  
- ein modernes UI basierend auf Laravel Breeze und Tailwind CSS  

## 1.2 Zielsetzung  
Ziel des Projekts ist die Entwicklung eines **professionellen, sicheren und erweiterbaren Admin‑Systems**, das:

- ein sauberes Rollen‑ und Rechtekonzept implementiert  
- alle Benutzeraktionen nachvollziehbar protokolliert  
- eine moderne, intuitive Benutzeroberfläche bietet  
- eine klare Architektur für zukünftige Erweiterungen ermöglicht  

## 1.3 Anforderungen laut Aufgabenstellung  
- Entwicklung eines eigenen Laravel‑Projekts  
- Bereitstellung eines Git‑Repositories  
- Erstellung einer Projektdokumentation  
- Erstellung eines README zur Installation  
- Präsentation des Projekts  

---

# 2. Technologien & Entwicklungsumgebung

## 2.1 PHP-Version  
- **PHP 8.3.30**

## 2.2 Laravel-Version  
- **Laravel 12.49.0**

## 2.3 Verwendete Pakete & Tools  
- Laravel Breeze (Auth + UI)  
- Tailwind CSS  
- Laravel Sanctum (API‑Authentifizierung)  
- Laravel Policies  
- **Custom Activity Logging Trait (mit Diff‑Unterstützung)**  
- Chart.js (Analytics‑Diagramm)

## 2.4 Datenbank  
- **SQLite** – ideal für portable Entwicklungsumgebungen

## 2.5 Entwicklungsumgebung  
- VSCode  
- Composer  
- Node.js & npm  
- Git  

---

# 3. Systemarchitektur

## 3.1 MVC-Struktur  
Das Projekt folgt dem Laravel‑MVC‑Pattern:

- **Models:** User, Role, Permission, ActivityLog  
- **Views:** Blade‑Templates (Breeze)  
- **Controller:** Admin‑Controller für CRUD‑Operationen  
- **Traits:** LogActivity für automatisches Logging  

## 3.2 Projektstruktur (Auszug)

```
app/
 ├── Http/Controllers/Admin
 ├── Models
 ├── Policies
 └── Traits/LogActivity.php
resources/
 └── views/admin
database/
 ├── migrations
 └── seeders
routes/
 ├── web.php
 └── api.php
```

## 3.3 Routing-Konzept  
- `/admin/users` – Benutzerverwaltung  
- `/admin/roles` – Rollenverwaltung  
- `/admin/permissions` – Berechtigungen  
- `/admin/logs` – Activity Logs  
- `/admin/analytics` – Analytics Dashboard  
- `/api/*` – REST‑API  

## 3.4 Middleware  
- `auth` – schützt alle Admin‑Routen  
- `admin` – nur Admin‑Benutzer dürfen Rollen/Permissions verwalten  

## 3.5 Policies  
Policies steuern den Zugriff auf:

- User  
- Roles  
- Permissions  

Beispiel:

```php
public function update(User $user, User $model)
{
    return $user->hasPermission('user.update');
}
```

## 3.6 API-Authentifizierung  
Die API verwendet **Laravel Sanctum** für Token‑basierte Authentifizierung.

---

# 4. Datenbankdesign

## 4.1 Tabellenübersicht  
- `users`  
- `roles`  
- `permissions`  
- `role_user` (Pivot)  
- `permission_role` (Pivot)  
- `activity_logs`  

## 4.2 Beziehungen  
- Ein Benutzer kann mehrere Rollen haben (n:m)  
- Eine Rolle kann mehrere Berechtigungen haben (n:m)  
- Ein Benutzer kann viele Activity Logs haben (1:n)  

## 4.3 ER‑Diagramm (ASCII)

```
Users ───< role_user >─── Roles ───< permission_role >─── Permissions
  │
  └──< ActivityLogs
```

## 4.4 activity_logs Tabelle (erweitert)

| Feld | Beschreibung |
|------|--------------|
| user_id | Benutzer, der die Aktion ausgeführt hat |
| action | create / update / delete |
| model | Modellklasse |
| model_id | ID des betroffenen Datensatzes |
| old_values | JSON – vorherige Werte |
| new_values | JSON – neue Werte |
| ip_address | IP des Clients |
| url | Request‑URL |
| method | HTTP‑Methode |
| user_agent | Browser/Client |
| created_at | Zeitstempel |

---

# 5. Implementierung

## 5.1 Benutzerverwaltung (CRUD)  
- Benutzer erstellen  
- Benutzer bearbeiten  
- Benutzer löschen  
- Rollen zuweisen  

## 5.2 Rollenverwaltung (CRUD)  
- Rollen erstellen  
- Rollen bearbeiten  
- Rollen löschen  

## 5.3 Berechtigungsverwaltung (CRUD)  
- Permissions erstellen  
- Permissions bearbeiten  
- Permissions löschen  

## 5.4 Activity Logging (erweitert)

### Automatisch protokolliert werden:
- create  
- update  
- delete  

### Gespeicherte Daten:
- Benutzer  
- Modell  
- IP  
- URL  
- User Agent  
- **Old/New Values**  
- **Diff pro Feld**  

### Diff‑Beispiel:
```
name:
  Old: user200
  New: user20
```

### UI‑Features:
- Tabelle mit Logs  
- Filter & Suche  
- CSV‑Export  
- Modal „Show changes“  

## 5.5 Analytics Dashboard

### Funktionen:
- Gruppierung der Logs nach Datum  
- Anzeige der täglichen Aktivität  
- Diagramm mit Chart.js  

### Beispiel:
- 2026‑02‑23 → 5 Aktionen  
- 2026‑02‑22 → 3 Aktionen  

## 5.6 API-Endpunkte (Auszug)

| Methode | Endpoint | Beschreibung |
|--------|----------|--------------|
| GET | /api/users | Liste aller Benutzer |
| POST | /api/users | Benutzer erstellen |
| GET | /api/users/{id} | Einzelner Benutzer |
| PUT | /api/users/{id} | Benutzer aktualisieren |
| DELETE | /api/users/{id} | Benutzer löschen |

---

# 6. Rollen- & Berechtigungssystem

## 6.1 Rollen  
- **Admin** – Vollzugriff  
- **User** – eingeschränkter Zugriff  

## 6.2 Berechtigungen  
- user.create  
- user.update  
- user.delete  
- role.manage  
- permission.manage  

## 6.3 Zugriffskontrolle  
Über Policies und Middleware.

---

# 7. Installation & Deployment

(identisch mit README)

---

# 8. Tests & Qualitätssicherung

## 8.1 Automatisierte Tests  
Nicht implementiert.

## 8.2 Manuelle Tests  
- UI‑Tests  
- API‑Tests  
- Logging‑Tests  
- Diff‑Tests  

---

# 9. Fazit

## 9.1 Was wurde erreicht  
- Vollständiges Admin‑Dashboard  
- Rollen‑ und Berechtigungssystem  
- **Erweitertes Activity Logging mit Diff**  
- **Analytics Dashboard**  
- Moderne UI  
- REST‑API  

## 9.2 Herausforderungen  
- Diff‑Implementierung  
- Logging‑Struktur  
- Dashboard‑Analytics  

## 9.3 Erweiterungsmöglichkeiten  
- Mehr Diagramme  
- GitHub‑Style Diff  
- API‑Logging  
- Zwei‑Faktor‑Authentifizierung  

---

# 10. Anhang

## 10.1 Screenshots  
-

## 10.2 Git‑Repository  
https://github.com/nataliawinter93-bit/

---

