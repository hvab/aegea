<?php

  $settings_href = '../settings';
  $self_href = 'javascript:;';
  
  $return['class'] = 'themepreview';
  $return['title'] = 'Предпросмотр темы';
  $return['heading'] = 'Предпросмотр темы';

  // $return['theme-preview']['no-themes'] = '
  // <p>Чтобы сделать свою тему:</p>
  // <ol>
  //   <li>Сделайте копию понравившейся вам темы в папке <tt>themes</tt>.</li>
  //   <li>Отредактируйте <tt>theme-info.php</tt>.</li>
  //   <li>Переключитесь на свою новую тему <a href="'. $settings_href .'">в настройке</a>.</li>
  // </ol>
  // ';

  $return['theme-preview']['no-themes'] = '<p>На этой странице смотрите и настраивайте вашу тему оформления.</p>';

  // $return['theme-preview']['themes-before'] = '
  // <p>Выберите оформление:</p>
  // ';

  // $return['theme-preview']['themes-after'] = '
  // <p>Выберите тему из списка, чтобы переключиться в неё.</p>
  // <p>На этой странице смотрите и настраивайте вашу тему. Она состоит из элементов блога, начиная с заметок. Не забудьте проверить на мобильном телефоне.</p>
  // ';
  
  if (defined ('E2_EDITION') and E2_EDITION) {

    $return['theme-preview']['no-themes'] .= '<p>Главное меню показывает разные состояния пунктов: '.
      'обычная ссылка, ссылка на родительский раздел и выбранное название текущего раздела.</p>';

    $return['main-menu'] = [
      'each' => 
      [
        [
          'href' => $self_href,
          'svg-id' => 'favourite-on',
          'title' => 'Главное меню',
          'current?' => false,
          'parent?' => false,
          'visible?' => true,
        ],
        [
          'href' => $settings_href,
          'svg-id' => 'settings',
          'title' => 'Настройка',
          'visible?' => true,
          'parent?' => true,
          'current?' => false,
        ],
        [
          'href' => $self_href,
          'svg-id' => 'tags',
          'title' => 'Теги',
          'current?' => false,
          'parent?' => false,
          'visible?' => true,
        ],
        [
          'tag' => 'кино',
          'title' => 'Кино',
          'href' => $self_href,
          'visible?' => true,
          'parent?' => false,
          'current?' => false,
        ],
        [
          'tag' => 'музыка',
          'title' => 'Музыка',
          'href' => $self_href,
          'visible?' => true,
          'parent?' => false,
          'current?' => false,
        ],
        [
          'tag' => 'книги',
          'title' => 'Книги',
          'href' => $self_href,
          'visible?' => true,
          'parent?' => false,
          'current?' => false,
        ],
        [
          'href' => $self_href,
          'title' => 'Предпросмотр темы',
          'visible?' => true,
          'parent?' => false,
          'current?' => true,
        ],
      ],
      'reorderable?' => false,
    ];

  }

  $return['notes'] = [
    [
      'id' => 1,
      'title' => 'Заметка-образец',
      'text' => '
      <p>Так выглядит заметка. Это заметка со звездой. Во встроенной теме у неё крупный заголовок, но вы можете выделить его иначе.</p>
      <p>В этом абзаце — рыбный текст. Теория вчувствования свободна. Ритм изящно имеет фактографический хтонический миф. Художественное опосредование представляет собой катарсис. Литургическая драма имеет психологический параллелизм.</p>
      <h2>Подзаголовки, форматирование текста и картинки</h2>
      <p>В заметке могут быть подзаголовки, как здесь, <a href="'. $self_href .'">ссылки</a> и разные виды форматирования текста — <i>курсив</i>, <b>жирный</b>, <tt>моноширинный</tt>.</p>
      <p>Картинка с подписью:</p>
      <div class="e2-text-picture">
      <div style="width: 800px; max-width: 100%"><div class="e2-text-proportional-wrapper" style="padding-bottom: 44.375%"><img src="system/theme/images/sample-image.jpg" width="800" height="355" alt="">
      </div></div>
      <div class="e2-text-caption">Сотворение Адама. Микеланджело, ок. 1511 г.</div>
      </div>
      <p>Допустим, у нас есть важная мысль об этой картинке:</p>
      <p class="loud">И сотворил бог человека по образу своему</p>
      <p>За этим абзацем следует таблица. В этом абзаце — рыбный текст. Теория вчувствования свободна. Ритм изящно имеет фактографический хтонический миф. Художественное опосредование представляет собой катарсис. Литургическая драма имеет психологический параллелизм.</p>
      <div class="e2-text-table">
        <table cellpadding="0" cellspacing="0" border="0">
        <tr><th>Город</th><th>Часовой пояс</th><th>Код</th><th>К Гринвичу</th></tr>
        <tr><td>Челябинск</td><td>Екатеринбургское время</td><td><nobr>YEKT</nobr></td><td>+5 ч.</td></tr>
        <tr><td>Москва</td><td>Московское время</td><td><nobr>MSK</nobr></td><td>+3 ч.</td></tr>
        <tr><td>Лондон</td><td>Среднее время по Гринвичу</td><td><nobr>GMT</nobr></td><td></td></tr>
        <tr><td><nobr>Нью-Йорк</nobr></td><td>Североамериканское восточное время</td><td><nobr>ET</nobr></td><td>−5 ч.</td></tr>
        <tr><td><nobr>Сан-Франциско</nobr></td><td>Тихоокеанское время</td><td><nobr>PT</nobr></td><td>−8 ч.</td></tr>
        </table>
      </div>
      <p>Часть текста может быть отделена горизонтальной линейкой:</p>
      <hr />
      <p>А тут другой текст.</p>
      <h3>Заголовок третьего уровня</h3>
      <p>Упорядоченный список:</p>
      <ol>
        <li>Это длинный элемент списка, чтобы посмотреть, как выглядит перенос на несколько строк — убедитесь что отступы между элементами списка больше, чем между строками одного элемента.</li>
        <li>А это — короткий элемент.</li>
      </ol>
      <p>Неупорядоченный список:</p>
      <ul>
        <li>это длинный элемент списка, чтобы посмотреть, как выглядит перенос на несколько строк — убедитесь что отступы между элементами списка больше, чем между строками одного элемента;</li>
        <li>а это — короткий элемент.</li>
      </ul>
      ',
      // 'summary' => '',
      // 'format-info' => array 2
      // 'time' => e2 time 8 May 2017, 20:46, GMT+05:00
      // 'last-modified' => e2 time 14 May 2017, 19:51, GMT+05:00
      // 'last-ip' => NULL,
      'draft?' => false,
      'scheduled?' => false,
      'public?' => true,
      'hidden?' => false,
      'favourite?' => false,
      'tags' => [
        [
          'name' => 'тег',
          'href' => $self_href,
          'current?' => false,
          'visible?' => true,
        ],
        [
          'name' => 'другой тег',
          'href' => $self_href,
          'current?' => false,
          'visible?' => true,
        ],
        [
          'name' => 'скрытый тег',
          'href' => $self_href,
          'current?' => false,
          'visible?' => false,
        ],
      ],
      'read-count' => 42,
      'comments-count' => 5,
      'comments-count-text' => '5 комментариев',
      'href' => $self_href,
      'href-comments' => $self_href,
      // 'href-original' => 'http://e2/all/muzlo/',
      'comments-link?' => true,
      'new-comments-count' => 0,
      'new-comments-count-text' => '0 new',
      // 'favourite-toggle-action' => '',
      // 'edit-href' => 'http://e2/all/muzlo/edit/',
      // 'og-images' => [],
    ],
    [
      'id' => 2,
      'title' => 'Избранная заметка-образец',
      'text' => '
      <p class="lead">У этой заметки есть вводный абзац.</p>
      <p>Это ещё один пример¹, чтобы вы настроили расстояние между заметками в ленте. Заголовок этой заметки не является ссылкой — как будто мы уже на её странице. Ещё один из тегов снизу подсвечен — как будто мы на его странице.</p>
      <p class="foot">¹ А это — пример примечания. Оно весьма примечательно.</p>
      ',
      // 'summary' => '',
      // 'format-info' => array 2
      // 'time' => e2 time 8 May 2017, 20:46, GMT+05:00
      // 'last-modified' => e2 time 14 May 2017, 19:51, GMT+05:00
      // 'last-ip' => NULL,
      'draft?' => false,
      'scheduled?' => false,
      'public?' => true,
      'hidden?' => false,
      'favourite?' => true,
      'tags' => [
        [
          'name' => 'первый тег',
          'href' => $self_href,
          'current?' => false,
          'visible?' => true,
        ],
        [
          'name' => 'текущий тег',
          'href' => $self_href,
          'current?' => true,
          'visible?' => true,
        ],
        [
          'name' => 'и ещё один',
          'href' => $self_href,
          'current?' => false,
          'visible?' => true,
        ],
      ],
      'read-count' => 147,
      // 'comments-count' => 0,
      // 'comments-count-text' => '5 комментариев',
      // 'href' => $self_href,
      // 'href-original' => 'http://e2/all/muzlo/',
      // 'comments-link?' => true,
      // 'new-comments-count' => 2,
      // 'new-comments-count-text' => '2 new',
      // 'favourite-toggle-action' => '',
      // 'edit-href' => 'http://e2/all/muzlo/edit/',
      // 'og-images' => [],
    ],
    [
      'id' => 3,
      'title' => 'Пример заметки в результатах <mark>поиска</mark>',
      'text' => '',
      'snippet-text' => '
      <p>Так выглядит заметка в результатах <mark>поиска</mark>. Текст запроса <mark>подсвечивается</mark>, а все картинки из заметки показываются ниже. Некоторые из них тоже могут быть <mark>подсвечены</mark>. Тег <tt>mark</tt> используется для всей <mark>подсветки</mark>, включая тег в предыдущей заметке.</p>
      ',
      // 'summary' => '',
      // 'format-info' => array 2
      // 'time' => e2 time 8 May 2017, 20:46, GMT+05:00
      // 'last-modified' => e2 time 14 May 2017, 19:51, GMT+05:00
      // 'last-ip' => NULL,
      'draft?' => false,
      'scheduled?' => false,
      'public?' => true,
      'hidden?' => false,
      'favourite?' => false,
      'read-count' => 31,
      'thumbs' => [
        [
          'is-available?' => true,
          'src' => 'system/theme/images/sample-thumb-1@2x.jpg',
          'width' => 100,
          'height' => 79,
          'highlighted?' => false,
        ],
        [
          'is-available?' => true,
          'src' => 'system/theme/images/sample-thumb-2@2x.jpg',
          'width' => 100,
          'height' => 67,
          'highlighted?' => false,
        ],
        [
          'is-available?' => true,
          'src' => 'system/theme/images/sample-thumb-3@2x.jpg',
          'width' => 100,
          'height' => 44,
          'highlighted?' => true,
        ],
      ],
      // 'comments-count' => 5,
      // 'comments-count-text' => '5 comments',
      'href' => $self_href,
      'href-comments' => $self_href,
      // 'href-original' => 'http://e2/all/muzlo/',
      // 'comments-link?' => true,
      // 'new-comments-count' => 2,
      // 'new-comments-count-text' => '2 new',
      // 'favourite-toggle-action' => '',
      // 'edit-href' => 'http://e2/all/muzlo/edit/',
      // 'og-images' => [],
    ],
  ];

  $return['pages'] = [
    'timeline?' => true,
    'count' => 2,
    'this' => 1,
    'earlier-href' => $self_href,
    'earlier-title' => 'Ранее',
    // 'later-href' => $self_href,
    // 'later-title' => 'Later',
    // 'prev-href' => 'http://e2/all/nastraivaem-https-na-hostinge-timeweb-dlya-egei/',
    // 'prev-title' => 'Настраиваем HTTPS на хостинге TimeWeb для Эгеи',
    // 'title' => 'Posts',
    // 'this-title' => 'Музло',
  ];

  $return['comments'] = [
    'each' => [
      [
        'gip-used?' => true,
        'gip' => 'twitter',
        'userpic-set?' => true,
        'userpic-href' => 'system/theme/images/sample-face-1.jpg',
        'important?' => false,
        'name' => 'Иван Петров',
        'text' => '<p>Это комментарий для примера. Далее идёт бессмысленный текст. Этот текст нужен только чтобы вы могли увидеть, как выглядит многострочный комментарий.</p><p>И ещё один абзац на всякий случай.</p>',
        'time' => [
          0 => strtotime ('21 May 2019, 11:21 +0300'),
          1 => [
            'offset' => 10800,
            'is_dst' => false,
          ],
        ],
        'replied?' => true,
        'reply-visible?' => true,
        'reply-important?' => true,
        'author-name' => 'Александр Пушкин',
        'reply' => '<p>Ёмкий ответ автора.</p>',
        'reply-time' => [
          0 => strtotime ('15 Jun 2019, 22:13 +0300'),
          1 => [
            'offset' => 10800,
            'is_dst' => false,
          ],
        ],
      ],
      [
        'gip-used?' => true,
        'gip' => 'facebook',
        'userpic-set?' => true,
        'userpic-href' => 'system/theme/images/sample-face-2.jpg',
        'important?' => false,
        'name' => 'Констанция Константиновна Константинопольская',
        'text' => '<p>Короткий комментарий.</p>',
        'time' => [
          0 => strtotime ('29 May 2019, 11:21 +0300'),
          1 => [
            'offset' => 10800,
            'is_dst' => false,
          ],
        ],
      ],
    ],
    'toggle' => [
      // 'form-action' => '',
      'submit-text' => 'Закрыть комментарии к заметке',
    ],
    // 'rss-href' => 'http://e2/all/muzlo/comments-rss/',
    'count' => 2,
    'count-text' => '2 комментария',
    // 'new-count' => 0,
    // 'new-count-text' => '0 new',
    'display-form?' => true,
  ];

  $return['form-comment'] = [
    // '.note-id' => '4114',
    // '.comment-id' => 'new',
    // '.already-subscribed?' => false,
    'create:edit?' => true,
    'logged-in?' => true,
    'logged-in-gip' => 'facebook',
    'logout-url' => $self_href,
    // 'form-action' = 'http://e2/@actions/comment-process/',
    'submit-text' => 'Отправить',
    'show-subscribe?' => true,
    'subscribe?' => false,
    'subscription-status' => '',
    'email-field-name' => 'elton-john',
    'name' => 'Иван Петров',
    'email' => '',
    'text' => 'Это пример формы комментариев',
  ];


  return $return;

?>