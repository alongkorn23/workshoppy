# Workshoppy-Projekt
Bei diesem Projekt handelt es sich um eine Bachelorarbeit von Herr Alongkorn Kiatmontri, welche am 28.08.2019 zur Erlangung des akademischen Grades Bachelor of Science an der HTW Berlin vorgelegt wurde.

## Kurzfassung des Projektes
Ziel dieser Bachelorarbeit ist es, eine Webanwendung zu entwickeln, über welche Workshops in Echtzeit durchgeführt werden können. Dazu werden Workshops angelegt und in einer Datenbank gespeichert. Das Erarbeiten von Ergebnissen erfolgt in einer Sitzung, welche ebenfalls in einer Datenbank gespeichert werden. Mit Hilfe des WebSockets und des Web Application Messaging Protocols soll die Datenübermittlung von mehreren Personen in Echtzeit geprüft werden. Das Hauptaugenmerk dieser Arbeit wird auf die Datenausgabe von mehreren Personen in Echtzeit und die digitale Datenzusammenfassung gelegt. Der Beamer wird dabei als Ausgabemedium verwendet. Außerdem passt sich diese Anwendung automatisch an die Auflösung und Darstellung des jeweiligen Endgerätes (Smartphone, Tablet und PC) an. 

## Funktionsweise der Webanwendung
![Konzeption der Webanwendung](Anforderung_neu.png)

- Nach der erfolgreichen Anmeldung wird der Nutzer, der für die Durchführung des Workshops verantwortlich ist, auf die Hauptseite der Webanwendung weitergeleitet. Im Bereich „Workshop-Liste" werden die erstellten Workshops aufgelistet. Mit dem „Workshop erstellen"-Button kann ein neuer Workshop erstellt werden. Durch das Anklicken des Edit- sowie Löschen-Buttons kann der einzelne Workshop gezielt bearbeitet und gelöscht werden. Die beendeten Workshops werden im Bereich „Beendete Workshops" archiviert. Der Ergebnisse-Button führt zur der Ergebnisse-Seite des archivierten Workshops.

- Jeder Workshop hat seine eigene Controller-Seite. Auf dieser sind der Titel des Workshops (Nr.1), die Navigation-Tabs (Nr.2) und die Session-Liste (Nr.3) zu sehen.
