# Workshoppy-Projekt
Bei diesem Projekt handelt es sich um eine Bachelorarbeit von Herr Alongkorn Kiatmontri, welche am 28.08.2019 zur Erlangung des akademischen Grades Bachelor of Science an der HTW Berlin vorgelegt wurde.

## Kurzfassung des Projektes
Ziel dieser Bachelorarbeit ist es, eine Webanwendung zu entwickeln, über welche Workshops in Echtzeit durchgeführt werden können. Dazu werden Workshops angelegt und in einer Datenbank gespeichert. Das Erarbeiten von Ergebnissen erfolgt in einer Sitzung, welche ebenfalls in einer Datenbank gespeichert werden. Mit Hilfe des WebSockets und des Web Application Messaging Protocols soll die Datenübermittlung von mehreren Personen in Echtzeit geprüft werden. Das Hauptaugenmerk dieser Arbeit wird auf die Datenausgabe von mehreren Personen in Echtzeit und die digitale Datenzusammenfassung gelegt. Der Beamer wird dabei als Ausgabemedium verwendet. Außerdem passt sich diese Anwendung automatisch an die Auflösung und Darstellung des jeweiligen Endgerätes (Smartphone, Tablet und PC) an. 

Die Webanwendung ist erreichbar unter **https://wsdemo.ctrl-bln.de** . Der Benutzername und das Passwort werden zunächst nur in meinem Lebenslauf veröffentlicht. Falls Sie wirklich mit dieser Webanwendung beschäftigen wollen, schreiben Sie mir eine Mail an alongkorn23@googlemail.com, um die Login-Daten anzufordern.

**Vorsicht:** Die Webanwendung wirkt auf den ersten Blick viel zu kompliziert. Aus diesem Grund lesen Sie bitte nebenbei die Anleitung der Webanwendung durch, um die Funktionsweise der Webanwendung zu verstehen.

## Beispielszenario 
In diesem Abschnitt wird die Webanwendung anhand eines Beispielszenarios näher beschrieben.
Man stelle sich folgende Situation vor: Sie führen ein Unternehmen und suchen für ein Problem eine Lösung. Hier
sind also die Ideen gefragt. Sie laden alle Abteilungsleiter in den Besprechungsraum ein und führen dazu einen
Workshop, um die Lösungsansätze zu erarbeiten. Beim Erarbeiten von Ergebnissen spielt dabei die hierarchische
Position im Unternehmen keine Rolle. In einem Workshop ist jeder „gleich“.

Sie übernehmen die Rolle eines Moderators und erläutern den teilnehmenden Personen das zu behandelnde Problem,
die Regeln sowie das Ziel des Workshops. Als Werkzeug für die Durchführung des Workshops steht Ihnen
diese Webanwendung zur Verfügung. Bevor Sie mit dem Workshop beginnen, legen Sie bei der Webanwendung einen Workshop und die dazugehörige Session an. In dieser Session findet die Ideenfindungsphase statt. Jeder der im Besprechungsraum anwesenden Teilnehmer scannt den angezeigten QR-Code ein, um an diesem Workshop teilnehmen zu können. Danach kommt jeder dran und gibt auf seinem Endgerät Ideen für die Lösung des Problems ein. Jede eingebrachte Idee wird mittels Beamer in Echtzeit präsentiert. Die Ideenfindungsphase ist vorüber. Sie als Administrator beenden die Eingabephase auf der Webanwendung. Hier dürfen die anwesenden Teilnehmer keine Ideen mehr eingeben. Sie haben jetzt die Aufgabe,
die gesammelten Ideen gemeinsam mit der Gruppe zu analysieren und anschließend zusammenzufassen. Am Ende
des Workshops stehen Ihnen die Ergebnisse als digitale Dokumentation zur Verfügung.

## Anleitung zum erfolgreichen Durchführen der Webanwendung
**Akteure:** Der Moderator übernimmt die Rolle des Administrators und ist hauptverantwortlich für die Steuerung der Webanwendung. Die teilnehmenden Personen sind wiederum nur für die inhaltlichen Beiträge zuständig.
  
* Nach der erfolgreichen Anmeldung wird der Nutzer, der für die Durchführung des Workshops verantwortlich ist, auf die **Hauptseite** der Webanwendung weitergeleitet. Im Bereich „Workshop-Liste” werden die erstellten Workshops aufgelistet. Mit dem „Workshop erstellen”-Button kann ein neuer Workshop erstellt werden. Durch das Anklicken des Edit- sowie Löschen-Buttons kann der einzelne Workshop gezielt bearbeitet und gelöscht werden. Die beendeten Workshops werden im Bereich „Beendete Workshops” archiviert. Der Ergebnisse-Button führt zur der Ergebnisse-Seite des archivierten Workshops.

* Jeder Workshop hat seine eigene **Controller-Seite**.
  * Das Navigation-Tab „WS-Controller” beinhaltet vier folgende Buttons: 
    * Client-Button: öffnet die Teilnehmer-Seite als neues Browser-Tab. Auf dieser Seite können die Teilnehmer die Dateneingabe tätigen. 
    
    **Anmerkung**: Der Client-Button wird in der zukünftigen Weiterentwicklung entfernt, da der Moderator nicht für die Dateneingabe beteiligt werden darf. Für diese Arbeit wird der Client-Button aufgrund des Funktionstests erstmal erhalten bleiben.
    
    * Präsentation-Button: öffnet als neues Browser-Fenster die Präsentation-Seite. Mittels Beamer präsentiert sie den Teilnehmern die eingegebenen Daten in Echtzeit.
  
    * Ergebnisse-Button: öffnet ein neues Browser-Tab und ruft die Ergebnisse-Seite auf. Die Zwischenergebnisse des Workshops werden dargestellt. Der Ergebnisse-Button ist erst aktiviert, wenn die Ergebnisse vorhanden sind.
  
    * Beenden-Button: beendet den laufenden Workshop und leitet den Moderator zur Hauptseite weiter. Der Workshop wird anschließend in „Beendete Workshops” archiviert.

  * Die Agenda, falls sie vorhanden ist, wird im Navigation-Tab „Agenda” dargestellt.
  * Neben dem Einscannen des QR-Codes auf der Präsentation-Seite können die Teilnehmer im Navigation-Tab „Teilnehmer” die Einladung per Mail senden lassen, um am Workshop teilzunehmen.
  * Das Brainstorming wird in der Session-Liste durchgeführt. Zunächst muss der Moderator mit dem „Session-Erstellen-Button” eine neue Session anlegen.
  * Die behandelte Frage, die auf der Teilnehmer- und Präsentation-Seite zu sehen sein wird, muss definiert werden. Als Option kann der Titel der Session angegeben werden. Wie viele Sessions in einem Workshop benötigt werden, das entscheidet der Moderator selbst. Er kann unbegrenzt viele Sessions erstellen.
  * Neben jeder Session sind drei Buttons zu sehen. 
    * Edit-Button: Mit diesem Button kann die Titel- sowie Fragenänderung durchgeführt werden.
    * Löschen-Button: Der Löschen-Button löscht die Session inklusive ihrer zugehörigen Daten.
    * Starten-Button: Es wird erst **„gebrainstormt”**, wenn die Session gestartet ist. In dieser Session wird versucht, möglichst viele Ideen für ein zuvor klar definiertes Problem zu produzieren. Während die Session läuft, darf sie nicht bearbeitet und gelöscht werden. Alle Buttons von nicht aktiven Sessions werden auch in dieser Phase deaktiviert. Es kann nur eine Session gestartet werden. Außerdem kann der Workshop bei laufender Session nicht beendet werden. Der „Beenden-Button” in WS-Controller wird ebenfalls auch deaktiviert.
    
    **Anmerkung**: Es gibt zusätzlich noch zwei weiteren Buttons, welche erst sichtbar werden, wenn eine Session gerade läuft. Das ist der „Eingabe beenden”- und Session „Beenden”-Button.
    
    * Der „Eingabe beenden-Button” stoppt die Eingabe auf der Teilnehmer-Seite. Demzufolge können die Teilnehmer keine weiteren Daten mehr eingeben. Der „Session Beenden-Button” beendet die gerade laufende Session. Auf der Teilnehmer-Seite wird durch den Klick auf dem „Session Beenden-Button” der Infotext „Bitte Warten” angezeigt und gleichzeitig wird der QR-Code zur Teilnahme am Workshop auf der Präsentation-Seite dargestellt.
    
    * Erst nach dem Beenden der laufenden Session werden alle zuvor deaktivierten Buttons wieder reaktiviert.
    
* Um auf die **Teilnehmer-Seite** zu kommen, müssen die Teilnehmer des Workshops den QR-Code, welche auf der Präsentation-Seite (Beamer) zu sehen ist, einscannen oder sie lassen sich per Mail die Einladung zur Teilnahme am Workshop zusenden. Die Teilnehmer-Seite stellt jedem Workshop-Teilnehmer die Dateneingabefunktion zu einer gestarteten Session bereit. Beim Aufrufen der Seite werden die Teilnehmer zunächst aufgefordert, ihren Benutzernamen einzugeben.

* Nach Eingabe Ihres Benutzernamens werden die Teilnehmer auf die Eingabefunktion weitergeleitet. Erst wenn der Moderator eine Session startet, können die Teilnehmer die Dateneingabe tätigen.

* Die **Präsentation-Seite** dient der Darstellung der Dateneingabe von allen Teilnehmern in Echtzeit. Die Seite hat zwei Zustände, nämlich passiv und aktiv.

  * **passiver Zustand**:
Dieser Zustand bedeutet, dass momentan keine Session läuft. Die Präsentation-Seite zeigt bei diesem Zustand den QR-Code zur Teilnahme am Workshop an. Bevor die Session tatsächlich beginnt, können die Teilnehmer den QR-Code über Ihre Mobilgeräte einscannen, um am Workshop teilzunehmen.

  * **aktiver Zustand**:
Die Präsentation-Seite befindet sich im aktiven Zustand, wenn die Session gestartet ist. Auf der Präsentation-Seite werden die Dateneingaben der Teilnehmer in Echtzeit präsentiert.

  * Die behandelte Frage ist am oberen Inhaltsbereich zu sehen. Die Eingaben der Teilnehmer werden wie ein Notizzettel visualisiert. Ein Notizzettel besteht aus zwei Teilen, dem Namen des Teilnehmers und seine Idee. Am unteren Bereich der Präsentation-Seite befinden sich zwei Buttons. Während die Session läuft, kann der QR-Code des Workshops mit dem Drücken des QR-Code-Buttons angezeigt werden. Der QR-Code kann sowohl im passiven Zustand als auch im aktiven Zustand dargestellt werden. Der Vollbild-Button wandelt die Präsentation-Seite in den Vollbildmodus um. 
  
  * Um die angezeigten Daten auf der Präsentation-Seite zusammenfassen zu können, muss die Ideensammlungsphase beendet werden. Dafür klickt der Moderator auf den „Eingabe beenden”-Button auf der **Controller-Seite**. Daraus folgt, dass auf der **Teilnehmer-Seite** die Eingabe gestoppt und stattdessen der Infotext „Bitte Warten” angezeigt wird. Durch den Klick auf den „Eingabe beenden”-Button auf der Controller-Seite wird der „Kategorie erstellen”-Button auf der Präsentation-Seite freigeschaltet, mit dem der Moderator Kategorien erstellen kann.

  * Direkt auf der **Präsentation-Seite** kann der Moderator die Daten per Drag-&-Drop in Kategorien zusammenfassen. Die Kategorien selbst lassen sich nicht verschieben. Das Löschen einer Kategorie erfolgt mit dem Klick auf den X-Button. Es wird nur die Kategorie gelöscht, d.h. die darin befindlichen Daten bleiben auf der Präsentation-Seite erhalten.
  
* Mit Klick auf den **Ergebnisse-Button** wird die Ergebnisse-Seite des Workshops als neues Browser-Tab geöffnet. Auf dieser Seite befinden sich die Daten inklusive Kategorien des Workshops. Die Ergebnisse-Seite beinhaltet außerdem einen Button, mit dem die Ergebnisse als eine PDF-Datei heruntergeladen werden können.

## Zusammenfassung der Konzeption der Webanwendung
![Konzeption der Webanwendung](Anforderung_neu.png)

Der Moderator ist, wie bereits erwähnt, der Administrator der Webanwendung und ist für die Durchführung des Workshops verantwortlich. Er legt zunächst einen neuen Workshop und die dazugehörigen Session(s) an. In dieser Session wird versucht, möglichst viele Ideen für ein zuvor klar definiertes Problem zu produzieren (Brainstorming). Sobald der Moderator die Session startet, wird auf der Teilnehmer-Seite die Funktion zur Dateneingabe freigeschaltet. Die Präsentation-Seite ist bei einer aktiver Session in der Lage, die Dateneingabe von den Teilnehmern in Echtzeit darzustellen. 

Die Ideenfindungsphase ist vorüber. Der Moderator beendet anschließend die Eingabephase (Eingabe beenden). In dieser Situation wird auf der Teilnehmer-Seite die Funktion zur Dateneingabe ausgeblendet und dafür wird einen Hinweistext „Bitte Warten“ ausgegeben. Die Teilnehmer dürfen also keine Ideen mehr eingeben. Der Moderator analysiert die gesammelten Ideen gemeinsam mit der Gruppe und fasst sie anschließend in Kategorien zusammen. Nachdem die Zusammenfassung erfolgreich verlaufen ist, beendet der Moderator die Session. Bei nicht aktiver Session werden auf der Teilnehmer-Seite einen Hinweistext „Bitte Warten“ und auf der Präsentation-Seite den QR-Code zur Teilnahme am Workshop angezeigt. Am Ende des Workshops steht dem Moderator die Zusammenfassungen als digitale Dokumentation zur Verfügung und kann diese als PDF-Datei heruntergeladen werden.
