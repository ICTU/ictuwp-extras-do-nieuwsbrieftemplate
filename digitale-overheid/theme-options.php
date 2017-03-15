<?php
/*
 * This is a pre packaged theme options page. Every option name
 * must start with "theme_" so Newsletter can distinguish them from other
 * options that are specific to the object using the theme.
 *
 * An array of theme default options should always be present and that default options
 * should be merged with the current complete set of options as shown below.
 *
 * Every theme can define its own set of options, the will be used in the theme.php
 * file while composing the email body. Newsletter knows nothing about theme options
 * (other than saving them) and does not use or relies on any of them.
 *
 * For multilanguage purpose you can actually check the constants "WP_LANG", until
 * a decent system will be implemented.
 */

if (!defined('ABSPATH'))
    exit;

$theme_defaults = array(
    'theme_max_posts'   =>  5,
    'theme_max_agenda'  =>  5,
    'theme_read_more'   =>  'Lees meer',
    'theme_nieuwsbrieftitel'    =>  'Digitale Overheid - {date}',
    'theme_colofon_block_1'     =>  'Dit is een publicatie van de ministeries van Binnenlandse Zaken en Koninkrijksrelaties en van Economische Zaken.',
    'theme_colofon_block_2'     =>  'Heeft u tips of leuk nieuws voor de nieuwsbrief? Wij horen  graag van u! Stuur een email naar <a href="mailto:redactie@digitaleoverheid.nl">redactie@digitaleoverheid.nl</a>',
    'theme_colofon_block_3'      =>  'Digitale Overheid is ook te volgen op Twitter: <a href="https://twitter.com/digioverheid">@digioverheid</a>',
    'theme_categories'  =>  array()
    );

// Mandatory!
$controls->merge_defaults($theme_defaults);
?>
<table class="form-table">

<tr><td colspan="2">
<h2>Preselectie</h2>

<p>Je kunt de nieuwsbrief automatisch laten vullen met nieuwsberichten. </p>
<p>Met het aantal berichten bepaal je het maximum aantal berichten dat hierna automatisch aan je nieuwsbrief wordt toegevoegd.<br>
  De makkelijkste methode om de berichten die je in de nieuwsbrief wilt hebben tijdelijk te voorzien van een tag, zoals 'nieuwsbrief'. Deze tag kun je dan hieronder invoeren bij 'Filter op tag'; het wordt een criterium om de nieuwsberichten voor je nieuwsbrief automatisch te selecteren.<br>Je kunt de preselectie van nieuwsberichten ook beperken tot een categorie.</p>

</td></tr>
    <tr valign="top">
        <th>Piwik-trackercode</th>
        <td>
            <?php $controls->text('theme_piwiktrackercode'); ?>
        </td>
    </tr>
  
    <tr>
        <th>Aantal berichten</th>
        <td>Selecteer <?php $controls->text('theme_max_posts', 5); ?> berichten</td>
    </tr>
    <tr>
        <th>Afbeelding gebruiken</th>
        <td>
            <?php $controls->checkbox('theme_show_featuredimage', 'Toon uitgelichte afbeelding'); ?>
        </td>
    </tr>
    <tr>
        <th>Filter op tag</th>
        <td>
            <?php $controls->text('theme_tags', 30); ?>
            <p class="description" style="display: inline"> kommagescheiden invoeren</p>
        </td>
    </tr>

    <tr valign="top">
        <th>Filter op categorie</th>
        <td><?php $controls->categories_group('theme_categories'); ?></td>
    </tr>
    <tr valign="top">
        <th>'lees meer'-tekst</th>
        <td>
            <?php $controls->text('theme_read_more'); ?>
        </td>
    </tr>

    <tr valign="top">
        <th>Aantal items in agenda</th>
        <td>Selecteer <?php $controls->text('theme_max_agenda', 5); ?> items voor de agenda</td>
    </tr>


    <tr valign="top">
        <th>Titel in de nieuwsbrief</th>
        <td>
            <?php $controls->textarea('theme_nieuwsbrieftitel' ); ?>
            <p> <code>{date}</code> is <em lang="en">placeholder</em> voor de datum; bij het versturen van de nieuwsbrief wordt deze vervangen door de datum</p>
          <p>&nbsp;</p>
        </td>
    </tr>
    <tr valign="top">
        <th>Colofon - blok 1</th>
        <td>
            <?php $controls->textarea('theme_colofon_block_1' ); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Colofon - blok 2</th>
        <td>
            <?php $controls->textarea('theme_colofon_block_2' ); ?>
        </td>
    </tr>
    <tr valign="top">
        <th>Colofon - blok 3</th>
        <td>
            <?php $controls->textarea('theme_colofon_block_3' ); ?>
        </td>
    </tr>

</table>
