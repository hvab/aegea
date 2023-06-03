<?php

// display_name = Italiano

function e2l_load_strings () {

  return array (

  // engine
  'e2--vname-aegea' => 'Aegea',
  'e2--release' => 'rilascio',
  'e2--powered-by' => 'Azionato tramite',
  'e2--default-blog-title' => 'Mio blog',
  'e2--default-blog-author' => 'Autore del blog',
  'e2--website-host' => 'blogengine.me',
  'e2--currency-sign' => '€',
  
  // installer
  'pt--install' => 'Installare Aegea',
  'gs--user-fixes-needed' => 'Ebbene, qualcosa dev’essere risolto.',
  'gs--following-folders-missing' => 'Le seguenti cartelle mancato nel pacchetto:',
  'gs--could-not-create-them-automatically' => 'Non è stato possibile crearli automaticamente a causa di accesso negato. Carichi per favore al server l’intero pacchetto.',
  'gs--and-reload-installer' => 'E rilanci l’installatore',
  'fb--begin' => 'Cominciare a bloggare',
  'fb--retry' => 'Riprovare',
  'gs--db-parameters' => 'Parametri della banca dati che le ha dato il suo fornitore di hosting',
  'gs--ask-hoster-how-to-create-db' => 'Se necessario, chieda il suo fornitore di hosting come creare una banca dati',
  'er--double-check-db-params' => 'Verifichi i parametri della banca dati',
  'gs--instantiated-version' => 'Versione istanziata',
  'gs--database' => 'Banca dati',
  'gs--password-for-blog' => 'Parola d’accesso che vuole usare per accedere al suo blog',
  'gs--data-exists' => 'In questa banca dati c’è già un blog. L’installatore si collegherà ad essa.',
  'er--db-data-incomplete' => 'I dati in questa banca dati non sono completi.',
  'er--db-data-incomplete-install' => 'I dati in questa banca dati non sono completi. È probabilmente stata usata con una versione diversa di Aegea. Installi la versione d’Aegea con cui sono creati questi dati, poi aggiorni se necessario. Per un’installazione fresca, fornisca per favore una banca dati pulita',

  // diags
  'et--fix-permissions-on-server' => 'Aggiusti le autorizzazioni sul server',
  'gs--enable-write-permissions-for-the-following' => 'Attivi per favore le autorizzazioni qui:',
  
  // sign in
  'pt--sign-in' => 'Entrare',
  'er--cannot-write-auth-data' => 'Non è stato possibile scrivere i dati per l’autenticazione',

  // archive
  'pt--nth-year' => 'L’anno $[year]',
  'pt--nth-month-of-nth-year' => '$[month.monthname.long] dell’anno $[year]',
  'pt--nth-day-of-nth-month-of-nth-year' => 'Il $[day.ordinal] $[month.monthname.long] $[year]',
  'gs--nth-month-of-nth-year' => '$[month.monthname] $[year]',
  'gs--nth-day-of-nth-month-of-nth-year' => '$[day] $[month.monthname.short] $[year]',
  'gs--everything' => 'Tutto',
  'gs--calendar' => 'Calendario',
  'gs--part-x-of-y' => 'Parte $[part] di $[of]',
  
  // posts
  'ln--new-post' => 'Nuovo',
  'bt--close-comments-to-post' => 'Vietare commenti a questo post',
  'bt--open-comments-to-post' => 'Consentire commenti a questo post',
  'pt--new-post' => 'Nuovo post',
  'pt--edit-post' => 'Modificare post',
  'er--post-must-have-title-and-text' => 'Il post deve avere un titolo ed un testo',
  'er--error-updating-post' => 'Errore aggiornando questo post',
  'er--error-deleting-post-tag-info' => 'Errore rimuovendo l’informazione sulle parole chiavi di questo post',
  'er--wrong-datetime-format' => 'Formato di data e ora sbagliato. Dev’essere “dd.mm.yyyy hh:mm:ss”',  
  'ff--title' => 'Titolo',
  'ff--text' => 'Testo',
  'ff--saving' => 'Salvando...',
  'ff--save' => 'Salvare',
  'ff--summary' => 'Sommario',
  'ff--tags' => 'Parole chiavi',
  'ff--details' => 'Dettagli',
  'ff--urlname' => 'Nome nell’URL',
  'ff--post-time' => 'Ora della pubblicazione',
  // 'ff--alias' => 'Alias',
  // 'ff--change-time' => 'Modificare ora',
  'ff--delete' => 'Eliminare',
  'ff--edit' => 'Modificare',
  'fb--hide' => 'Nascondere',
  'fb--show' => 'Rendere visibile',
  'fb--withdraw' => 'Riconvertire in bozza',
  'ff--will-be-published' => 'Sarà pubblicato',
  'ff--is-published' => 'Pubblicato',
  'ff--at-address' => 'all’indirizzo',
  'gs--no-notes' => 'Non ci sono post.',
  'gs--will-be-published' => 'Sarà pubblicato',

  // uploads
  'er--cannot-create-thumbnail' => 'Non è stato possibile creare la miniatura',
  'er--cannot-upload-file-too-big' => 'Un file è troppo grosso',
  'er--cannot-upload-no-or-too-many-files' => 'Nessun o troppi fili sono stati ricevuti dal server',
  'er--cannot-upload' => 'Non è stato possibile caricare il file (errore $[error])',
  'er--cannot-register-upload' => 'Impossibile registrare il file caricato',
  'er--cannot-rename-file-exists' => 'Il file già esiste',

  // see e2NiceError.js!
  'er--supported-only-png-jpg-gif' => 'Sono supportati solo immagini png, webp, jpg e gif',
  'er--unsupported-file' => 'Sono supportati solo immagini png, webp, jpg, gif e svg, video mp4 e mov, e fili audio mp3',

  'ff--gmt-offset' => 'Differenza da GMT',
  'ff--with-dst' => '+1 in estate',
  
  'pt--post-deletion' => 'Eliminazione del post',
  'gs--post-will-be-deleted' => 'Il post “$[post]” sarà eliminato con tutti i commenti.',

  'gs--post-will-be-hidden' => 'Il post rimarrà sul suo posto, ma sarà visibile solo a lei. Altri non potranno vederlo anche con il link diretto. Lei potrà renderlo visibile dopo',
  'gs--post-will-be-withdrawn' => 'I commenti saranno eliminati, la data di pubblicazione dimenticata. Potrà ripubblicare dopo',

  // uploads
  'gs--kb' => 'KB',
  'mi--upload-file' => 'Caricare file',
  'mi--rename' => 'Rinominare',
  'mi--delete' => 'Eliminare',
  'mi--insert' => 'Inserire',

  // frontpage 
  'nm--posts' => 'Post',
  'gs--next-posts' => 'prossimi',
  'gs--prev-posts' => 'precedenti',
  'gs--unsaved-changes' => 'Modifiche non salvate:',
  
  // drafts
  'ln--drafts' => 'Bozze',
  'pt--drafts' => 'Bozze',
  'pt--draft-deletion' => 'Eliminazione della bozza',
  'pt--edit-draft' => 'Modificare bozza',
  'gs--no-drafts' => 'Non ci sono bozze.',
  'gs--not-published' => 'Non pubblicato',
  'gs--secret-link' => 'Link segreto',
  'gs--draft-will-be-deleted' => 'La bozza “$[draft]” sarà eliminata.',
  
  // comments
  'pt--new-comment' => 'Nuovo commento',
  'pt--edit-comment' => 'Modificare commento',
  'pt--reply-to-comment' => 'Rispondere al commento',
  'pt--edit-reply-to-comment' => 'Modificare risposta al commento',
  'pt--unsubscription-done' => 'Eseguito',
  'pt--unsubscription-failed' => 'Non eseguito',
  'gs--you-are-no-longer-subscribed' => 'Non segue più i commenti a questo post',
  'gs--you-are-not-subscribed' => 'Sembra che lei non segue già i commenti a questo post',
  'gs--unsubscription-didnt-work' => 'È stato impossibile disiscriverla per una ragione sconosciuta',
  'gs--post-not-found' => 'Post non trovato',
  'gs--comment-double-post' => 'Commento doppio',
  'gs--comment-double-post-description' => 'Ha lasciato lo stesso commento più di una volta, solo uno era pubblicato.',
  'gs--comment-too-long' => 'Commento troppo lungo',
  'gs--comment-too-long-description' => 'Ha lasciato un commento molto lungo, non è stato pubblicato.',
  'gs--comment-post-not-commentable' => 'Commenti disattivati',
  'gs--comment-post-not-commentable-description' => 'Ha lasciato un commento, ma i commenti a questo post sono stati vietati.',
  'gs--comment-spam-suspect' => 'Il commento sembra di essere spam',
  'gs--comment-spam-suspect-description' => 'Scusi, il nostro robot ha deciso che questo commento è spam, perciò non è stato pubblicato.',
  'gs--you-are-already-subscribed' => 'Lei segue i commenti. Il link per disiscriversi c’è in ogni lettera con un commento nuovo.',
  'er--name-email-text-required' => 'Nome, mail e testo del commento sono tutti richiesti',
  'ff--notify-subscribers' => 'Notificare commentatore e altri iscritti via mail',
  'gs--your-comment' => 'Suo commento',
  'gs--sign-in-via' => 'Entrare via',
  'ff--full-name' => 'Nome e cognome',
  'ff--email' => 'Mail',
  'ff--subscribe-to-others-comments' => 'Ricevere altri commenti via mail',
  'ff--text-of-your-comment' => 'Testo del commento',
  'gs--n-comments' => '$[number.cardinal]',
  'gs--no-comments' => 'Nessun commento',
  'gs--comments-all-one-new' => 'nuovo',
  'gs--comments-all-new' => 'nuovi',
  'gs--comments-n-new' => '$[number.cardinal]',
  'mi--reply' => 'Rispondere',
  'mi--edit' => 'Modificare',
  'mi--highlight' => 'Evidenziare',
  'mi--remove' => 'Rimuovere',
  'gs--replace' => 'Rimettere al posto',

  // tags
  'pt--tags' => 'Parole chiavi',
  'pt--tag' => 'Parola chiave',
  'pt--posts-tagged' => 'Post con parola chiave',
  'tt--edit-tag' => 'Modificare parametri delle parole chiavi e la descrizione',
  'gs--tagged' => 'con parola chiave',
  'pt--tag-edit' => 'Modificare parola chiave',
  'pt--tag-delete' => 'Eliminare parola chiave',
  'pt--posts-without-tags' => 'Post senza parole chiavi',
  'gs--no-tags' => 'Non ci sono parole chiavi.',
  'gs--no-posts-without-tags' => 'Non ci sono post senza parole chiavi.',
  'gs--hidden' => 'Nascosto',
  'er--tag-must-have-name' => 'La parola chiave deve avere un nome',
  'er--cannot-rename-tag' => 'Questo nome o nome dell’URL sono usati già da un’altra parola chiave',
  'ff--tag-name' => 'Parola chiave',
  'ff--tag-page-title' => 'Titolo della pagina',
  'ff--tag-introductory-text' => 'Testo introduttivo',
  'gs--tag-will-be-deleted-notes-remain' => 'La parola chiave “$[tag]” sarà rimossa dai post, ma i post rimaranno.',
  'gs--see-also' => 'Veda anche',
  'gs--tags-important' => 'importanti',
  'gs--tags-all' => 'tutti',
  'gs--tags' => 'Parole chiavi',
  
  // most discussed and favourites
  'pt--most-commented' => 'Più discussi$[period.periodname]',
  'nm--most-commented' => 'Discussi',
  'pt--most-read' => 'Popolare$[period.periodname]',
  'nm--most-read' => 'Popolare',
  'pt--favourites' => 'Selezionato',
  'nm--favourites' => 'Selezionato',
  'gs--no-favourites' => 'Non ci sono post selezionati.',
  'nm--read-next' => 'Avanti',
  'nm--random-note' => 'Post a caso',
  
  // generic posts pages
  'nm--pages' => 'Pagine',
  'gs--page' => 'pagina',
  'gs--next-page' => 'prossima',
  'gs--prev-page' => 'precedente',
  'gs--earlier' => 'Prima',
  'gs--later' => 'Dopo',
  'pt--n-posts' => '$[number.cardinal]',
  'pt--no-posts' => 'Nessun post',
  
  // search
  'pt--search' => 'Ricerca',
  'pt--search-query-empty' => 'Testo di ricerca vuoto',
  'pt--search-query-too-short' => 'Testo di ricerca troppo corto',
  'gs--found-for-query' => 'trovato per',
  'gs--search' => 'Ricerca',
  'gs--search-query-empty' => 'Testo di ricerca vuoto, entri qualcosa.',
  'gs--search-query-too-short' => 'Testo di ricerca troppo corto, entri almeno 4 caratteri.',
  'gs--search-too-few-notes' => 'La ricerca funzionerà quando saranno pubblicati più appunti.',
  'gs--nothing-found' => 'Niente trovato.',
  'gs--many-posts' => 'Molti post',
  'pt--search-results' => 'Risultati di ricerca',
  
  // password, sessions, settings
  'pt--password' => 'Parola d’accesso',
  'pt--password-for-blog' => 'Parola d’accesso al blog',
  'ff--old-password' => 'Vecchia parola d’accesso',
  'ff--new-password' => 'Nuova parola d’accesso',
  'fb--change' => 'Modificare',
  'gs--password-changed' => 'La parola d’accesso è stata cambiata',
  'er--could-not-change-password' => 'Non è stato possibile cambiare la parola d’accesso',
  'er--no-password-entered' => 'Non ha entrato una parola d’accesso',
  'er--wrong-password' => 'Parola d’accesso sbagliata',
  'ff--displayed-as-plain-text' => 'mostrato in testo visibile',
  'er--settings-not-saved' => 'Impostazioni non salvate',
  'pt--password-reset' => 'Ripristino della parola d’accesso',
  'gs--password-reset-link-sent-maybe' => 'Se l’indirizzo è giusto, il link per ripristinare la parola d’accesso è stato inviato via mail',
  'gs--password-reset-link-saved' => 'Il link per ripristinare la parola d’accesso è stato salvato nel file password-reset.psa nella cartella utente del tuo blog sul server.',
  'er--cannot-reset-password' => 'Impossibile ripristinare parola d’accesso: nessuna mail è stata specificata nelle Impostazioni. Contatti l’amministratore.',
  'er--cannot-send-link-email-empty' => 'Impossibile inviare link per ripristinare la parola d’accesso: nessuna mail specificata',
  'gs--i-forgot' => 'Ho dimenticato',
  'em--password-reset-subject' => 'Ripristinare parola d’accesso Aegea',
  'em--follow-this-link' => 'Segua questo link per ripristinare parola d’accesso:',
  
  'pt--sessions' => 'Sessioni aperte',
  'gs--sessions-description' => 'Quando entra con la sua parola d’accesso su multipli dispositivi o navigatori web, questa pagina mostra una lista di tutte queste sessioni. Se qualsiasi sembra strana, chiuda tutte sessioni tranne questa e poi cambi la parola d’accesso.',
  'gs--sessions-browser-or-device' => 'Navigatore web o dispositivo',
  'gs--sessions-when' => 'Quando',
  'gs--sessions-from-where' => 'Da dove',
  'gs--locally' => 'localmente',
  'gs--unknown' => 'sconosciuto',
  'fb--end-all-sessions-but-this' => 'Chiudere tutte sessioni tranne questa',
  'gs--ua-iphone' => 'iPhone',
  'gs--ua-ipad' => 'iPad',
  'gs--ua-opera' => 'Opera',
  'gs--ua-firefox' => 'Firefox',
  'gs--ua-chrome' => 'Chrome',
  'gs--ua-safari' => 'Safari',
  'gs--ua-unknown' => 'Sconosciuto',
  'gs--ua-for-mac' => 'per Mac',

  'pt--settings' => 'Preferenze',
  'ff--language' => 'Lingua',
  'ff--theme' => 'Tema',
  'ff--theme-how-to' => 'Come creare un tema?',
  'gs--theme-preview' => 'Anteprima',
  'ff--main-menu' => 'Menù principale',
  'ff--show' => 'Mostrare',
  'gs--after-you-publish' => '(quando pubblica qualcosa)',
  'gs--main-menu-description' => 'Il menù principale mostra le parole chiavi appese, i link alle pagine speciali scelte sotto e la casella di ricerca. Gli elementi possono essere riordinati direttamente nel menù',
  'gs--how-to-pin-tags' => 'Appendere parole chiavi individuali con il pulsante ::svg:: sulle loro pagine',
  'ff--posts' => 'Post',
  'ff--respond-to-dark-mode' => 'Abilitare modalità scura',
  'ff--items-per-page-after' => 'per pagina',
  'ff--show-view-counts' => 'Mostrare ::svg:: conteggio di visualizzazioni',
  'ff--show-sharing-buttons' => 'Mostrare pulsanti di condivisione social',
  'ff--comments' => 'Commenti',
  'ff--comments-enable-by-default' => 'Consentire predefinitamente per post nuovi',
  'ff--comments-require-social-id' => 'Richiedere identificazione con social',
  'ff--only-for-recent-posts' => 'Solo per post recenti',
  'ff--send-by-email' => 'Inviare via mail',
  'ff--analytics' => 'Analitiche',
  'ff--yandex-metrika' => 'Yandex.Metrika',
  'ff--google-analytics' => 'Google Analytics',
  'gs--password' => 'Parola d’accesso',
  'gs--db-connection' => 'Collegamento alla banca dati',
  'gs--get-backup' => 'Scaricare ultimo archivio',
  'gs--not-paid' => 'Aegea non è stata pagata',
  'gs--paid-until' => 'Aegea è stata pagata fino al',
  'gs--paid-period-ended' => 'Finito periodo a pagamento',
  'bt--learn-about-payment' => 'Scoprire di più sul pagamento',
  'gs--used' => 'Usati $[used] di $[total] MB ($[percent]%)',
  'gs--used-all' => 'Il spazio è riempito: $[total] MB',
  
  'ff--blog-title' => 'Titolo del blog',
  'ff--subtitle' => 'Sottotitolo',
  'gs--remove-userpic' => 'Rimuovere foto',
  'ff--blog-description' => 'Descrizione del blog',
  'gs--search-engines-social-networks-aggregators' => 'Per motori di ricerca, aggregatori e social',
  'ff--blog-author-picture-and-name' => 'Foto e nome dell’autore',

  'pt--database' => 'Banca dati',
  'ff--db-host' => 'Server',
  'ff--db-username-and-password' => 'Nome utente e parola d’accesso',
  'ff--db-name' => 'Nome della banca dati',
  'fb--connect-to-this-db' => 'Collegare con questi parametri',
  'er--cannot-save-data' => 'Impossibile salvare dati',
  'gs--drag-userpic-here' => 'Trascini qui sua foto',

  // welcome
  'pt--welcome' => 'Creato!',
  'pt--welcome-text-pre' => 'Suo blog è stato creato. ',
  'pt--welcome-text-href-write' => 'Scriva un post',
  'pt--welcome-text-or' => ' o ',
  'pt--welcome-text-href-settings' => 'imposti le preferenze',
  'pt--welcome-text-post' => '.',

  // need for password
  'gs--need-password' => 'Sua parola d’accesso',
  'ff--public-computer' => 'Computer pubblico',
  'gs--frontpage' => 'Pagina principale',
  
  // form buttons
  'fb--submit' => 'Submit',
  'fb--save-changes' => 'Salvare modifiche',
  'fb--save-and-preview' => 'Salvare e vedere anteprima',
  'fb--publish' => 'Pubblicare',
  'fb--publish-note' => 'Pubblicare il post',
  'fb--publish-note-at-this-time' => 'Pubblicare il post a quest’ora',
  'fb--select' => 'Selezionare',
  'fb--apply' => 'Applicare',
  'fb--delete' => 'Eliminare',
  'fb--sign-in' => 'Entrare',
  'fb--sign-out' => 'Uscire',
  'fb--send-link-by-email' => 'Inviare link a questo indirizzo',
  
  // time
  'pt--default-timezone' => 'Fuso orario standard',
  'gs--e2-stores-each-posts-timezone' => 'Aegea memorizza il fuso orario di ogni post separatamente.',
  'gs--e2-autodetects-timezone' => 'Quando il post è pubblicato, il fuso orario è normalmente rilevato automaticamente. In caso di fallimento, sarà usato il fuso orario selezionato qui.',

  'tt--from-the-future' => 'Dal futuro',
  'tt--now' => 'adesso',
  'tt--just-now' => 'Appena adesso',
  'tt--one-minute-ago' => 'Un minuto fa',
  'tt--minutes-ago' => '$[minutes.cardinal] fa',
  'tt--one-hour-ago' => 'Un’ora fa',
  'tt--hours-ago' => '$[hours.cardinal] fa',
  'tt--today' => 'Oggi',
  'tt--today-at' => 'Oggi alle $[time]',

  'tt--seconds-short' => '$[value.cardinal]',
  'tt--minutes-short' => '$[value.cardinal]',
  'tt--hours-short' => '$[value.cardinal]',
  'tt--days-short' => '$[value.cardinal]',
  'tt--months-short' => '$[value.cardinal]',
  'tt--years-short' => '$[value.cardinal]',

  'tt--date' => '$[day] $[month.monthname.short]',
  'tt--date-and-time' => '$[day] $[month.monthname.short], $[time]',
  'tt--date-year-and-time' => '$[day] $[month.monthname.short] $[year], $[time]',

  'tt--zone-pt' => 'Ora del Pacifico',
  'tt--zone-mt' => 'Ora delle Montagne Rocciose',
  'tt--zone-ct' => 'Ora centrale',
  'tt--zone-et' => 'Ora orientale',
  'tt--zone-gmt' => 'Ora di Greenwich',
  'tt--zone-cet' => 'Ora dell’Europa Centrale',
  'tt--zone-eet' => 'Ora dell’Europa Est',
  'tt--zone-msk' => 'Ora di Mosca',
  'tt--zone-ekt' => 'Ora di Celiabinsk',
  'gs--timezone-offset-hours' => 'h',
  'gs--timezone-offset-minutes' => 'min',

  // mail
  'em--comment-new-to-author-subject' => '$[commenter] commenta $[note-title]',
  'em--comment-new-to-public-subject' => '$[commenter] commenta $[note-title]',
  'em--comment-reply-to-public-subject' => '$[blog-author] risponde al commento',
  'em--comment-reply' => '$[note-title] ($[blog-author] risponde)',
  'em--created-automatically' => 'Questa lettera è stata creata automaticamente',
  'em--unsubscribe' => 'Disiscriversi da questa discussione',
  'em--reply' => 'Rispondere',
  'em--comment-replied-to' => 'Commento con risposta',

  // rss
  'gs--posts-tagged' => 'post con parola chiave',
  
  'gs--follow-this-blog' => 'Seguire questo blog',

  // social networks
  'sn--twitter-verb' => 'Twittare',
  'sn--facebook-verb' => 'Condividere',
  'sn--linkedin-verb' => 'Condividere',
  'sn--vkontakte-verb' => 'Condividere',
  'sn--telegram-verb' => 'Inviare',
  'sn--whatsapp-verb' => 'Inviare',
  'sn--pinterest-verb' => 'Pinnare',

  // updating
  'pt--confused' => 'Aegea è confusa',
  'gs--downdate-explanation' => 'Questo server è stato usato con Aegea $[dr], ma ha una versione antecedente $[rr] che potrebbe non conoscere nuove funzioni e formati dei dati. Per proteggere suoi dati, Aegea ha deciso di non toccare niente e semplicemente fermarsi.',  

  'pt--updating' => 'Aegea si sta aggiornando',
  'gs--this-takes-seconds' => 'Normalmente questo occupa alcuni secondi.',

  'pt--fix-permissions' => 'Aggiustare autorizzazioni',
  'gs--fix-permissions' => 'Aegea deve avere la possibilità di scrivere alcuni fili.',

  'pt--multi-step-update' => 'Aggiornamento con tappe molteplici',
  'gs--multi-step-update-p1' => 'Per completare l’aggiornamento a $[rr], aggiorni prima a Aegea 2.10.',
  'gs--multi-step-update-p2' => 'Aegea conosce come aggiornarsi da $[ur] e versioni successive, ma il server era usato con Aegea $[dr]. Per proteggere suoi dati, Aegea ha deciso di non toccare niente e semplicemente fermarsi. Se torna al sistema precedente, tutto dovrebbe funzionare come prima.',

  'pt--update-cancelled' => 'Aegea ha annullato l’aggiornamento',
  'gs--dbs-version-too-old' => 'La versione $[dbs] che sta usando è $[dbv], ed è troppo vecchia. Aggiorni a MySQL $[minmysql] o una versione successiva o MariaDB $[minmariadb] o una versione successiva per usare Aegea $[aegearelease].',
  'gs--update-db-incomplete' => 'Aegea ha trovato dei dati nella sua banca dati, ma non sono completi.',
  'gs--update-db-no-data-configure-or-reinstall' => 'La banca dati sembra di essere vuota. Verifichi la configurazione della banca dati. Se vuole un nuovo blog, reinstalli Aegea.',

  // umacros
  'um--month' => '$[month.monthname]',
  'um--month-short' => '$[month.monthname.short]',
  'um--month-g' => '$[month.monthname]',
  
  // promo
  'pm--main-menu' => 'Nella versione a pagamento di Aegea, qua si configura il menù principale. Può contenere parole chiavi appese, e anche link ai post selezionati, più discussi e popolari, alla lista parole chiavi, al calendario ed a un post a caso. <a href="$[url]">Scoprire di più</a>',
  'pm--analytics' => 'Nella versione a pagamento di Aegea, può facilmente collegare Google Analytics e Yandex.Metrika da qui. <a href="$[url]">Scoprire di più</a>',
  'pm--secret-link' => 'Nella versione a pagamento di Aegea, può condividere una bozza privatamente, per esempio per approvare un post prima di pubblicarlo. <a href="$[url]">Scoprire di più</a>',
  'pm--scheduling' => 'Nella versione a pagamento di Aegea, può pianificare la pubblicazione di un post ad un’ora particolare o pubblicarlo nel passato. <a href="$[url]">Scoprire di più</a>',

  // more strings
  'gs--follow' => 'Seguire questo blog',
  
  'gs--no-such-notes' => 'Non ci sono post.',
  'pt--page-not-found' => 'Pagina non trovata',
  'gs--page-not-found' => 'Pagina non trovata.',
  
  'er--cannot-find-db' => 'Non posso trovare la banca dati',
  'er--cannot-connect-to-db' => 'Non posso collegarmi alla banca dati',
  'er--dbs-version-too-old' => 'La versione $[dbs] è troppo vecchia ($[v1], è richiesta $[v2]+)',
  'er--error-occurred' => 'C’è stato un errore',
  'er--too-many-errors' => 'Troppi errori',
  'gs--rss' => 'RSS',
  
  'gs--updated-successfully' => 'Aggiornato con successo dalla versione $[from] alla versione $[to]',
  'gs--pgt' => 'Tempo di generazione',
  'gs--seconds-contraction' => 's',
  'gs--good-blogs' => 'Bei blog e siti',

  'gs--range-separator' => '–',
  
  'ab--menu-actions' => 'Azioni',

  );

}



function e2lstr_monthname ($number, $modifier) {
  if ($modifier == 'long') {
    $tmp = array (
      'dicembre', 'gennaio', 'febbrario', 'marzo', 'aprile', 'maggio', 'giugno',
      'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre', 'gennaio'
    );
  }

  elseif ($modifier == 'short') {
    $tmp = array (
      'dic', 'gen', 'feb', 'mar', 'apr', 'mag', 'giu',
      'lug', 'ago', 'set', 'ott', 'nov', 'dic', 'gen'
    );
  } else {
    $tmp = array (
      'Dicembre', 'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
      'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre', 'Gennaio'
    );
  }
  return $tmp[(int) $number];
}


function e2lstr_periodname ($period) {
  /**/if ('year' == $period) return ' durante l’anno';
  elseif ('month' == $period) return ' durante il mese';
  elseif ('week' == $period) return ' durante la settimana';
  elseif ('day' == $period) return ' durante il giorno';
  else return '';
}


function e2lstr_ordinal ($number) {
  return $number;
}



function e2lstr_cardinal ($number, $modifier, $string_id) {
  $s = ($number > 1);

  $result = $number;
  if ($string_id == 'pt--n-posts') $result = $number .' post';
  if ($string_id == 'tt--minutes-ago') $result = $number .' minut'. ($s?'i':'o');
  if ($string_id == 'tt--hours-ago') $result = $number .' or'. ($s?'e':'a');
  if ($string_id == 'gs--n-comments') $result = $number .' comment'. ($s?'i':'o');
  if ($string_id == 'gs--comments-n-new') $result = $number .' nuov'. ($s?'i':'o');

  if ($string_id == 'tt--seconds-short') $result = $number .' s';
  if ($string_id == 'tt--minutes-short') $result = $number .' min';
  if ($string_id == 'tt--hours-short') $result = $number .' h';
  if ($string_id == 'tt--days-short') $result = $number .' gg';
  if ($string_id == 'tt--months-short') $result = $number .' mesi';
  if ($string_id == 'tt--years-short') $result = $number .' anni';

  return $result;
  
}



?>