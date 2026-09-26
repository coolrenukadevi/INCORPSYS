<?php
declare(strict_types=1);
/*
 * Leadership (CMS-ready). Names and designations were supplied by INCORPSYS; add the remaining fields when
 * available — never invent them. Empty fields are simply not shown.
 *   name, designation   required
 *   bio                 short biography (plain text)
 *   photo               path under assets/img/team/, e.g. 'team/anisha-bharti.webp'. If empty, a file named
 *                       {slug}.webp|.jpg|.png in assets/img/team/ is used when present; otherwise initials show.
 *   linkedin            full LinkedIn profile URL
 *   order               display order (ascending)
 */
return [
  ['name' => 'Anisha Bharti', 'designation' => 'Director', 'slug' => 'anisha-bharti', 'bio' => '', 'photo' => '', 'linkedin' => '', 'order' => 1],
  ['name' => 'Renuka Devi', 'designation' => 'Director', 'slug' => 'renuka-devi', 'bio' => '', 'photo' => '', 'linkedin' => '', 'order' => 2],
  ['name' => 'V.K Anand', 'designation' => 'Chief Executive Officer', 'slug' => 'vk-anand', 'bio' => '', 'photo' => '', 'linkedin' => '', 'order' => 3],
];
