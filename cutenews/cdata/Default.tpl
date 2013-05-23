<?php
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<div style="width:730px; margin-top:10px; margin-bottom:10px;">
[link]<div style="margin-left:10px;"><font size="4">{title}</font></div>[/link]

<div style="margin-left:10px; text-align:justify; padding:3px; margin-top:3px; margin-bottom:5px; border-top:1px solid #D3D3D3;">{short-story}
</div>

<div style="float: right;margin-top:5px;">[edit]Edit[/edit] [full-link]Read more[/full-link] | [com-link]{comments-num} Comments[/com-link]</div>

<div style="margin-left:10px;margin-top:11px;"><em>Posted in {category} on {date} by {author}</em></div>
</div>

HTML;


$template_full = <<<HTML
<div style="width:730px; margin-top:10px; margin-bottom:15px;">
<div style="margin-left:10px;"><strong><font size="4">{title}</strong></font></div>

{avatar}

<div style="margin-left:10px; text-align:justify;padding:3px; margin-top:3px; margin-bottom:5px; border-top:1px solid #D3D3D3;">
{full-story}
</div>

<div style="float: right;">{comments-num} Comments</div>

<div style="margin-left:10px;">[edit]Edit | [/edit]<em>Posted in {category} on {date} by {author}</em></div>
</div>
HTML;


$template_comment = <<<HTML
<div style="margin-left:10px;width: 400px; margin-bottom:20px;">

<div style="border-bottom:1px solid black;"><font size="2"> by <strong>{author}</strong> @ {date}</font></div>

<div style="padding:2px; background-color:#FFFFFF"><font size="2">{comment}</font></div>

</div>
HTML;


$template_form = <<<HTML
  <table border="0" width="370" cellspacing="0" cellpadding="0">
    <tr>

      <td width="60"><div style="margin-left:11px;"><font size="3">Name:</font></div></td>
      <td><input type="text" name="name" value="{username}"></td>

    </tr>
    <tr>
      <td colspan="2">
<div style="margin-left:10px;">
      <textarea cols="40" rows="6" id=commentsbox name="comments"></textarea><br />
      <input type="submit" name="submit" value="Add My Comment">
</div>
          </td>
    </tr>
  </table>

HTML;


$template_prev_next = <<<HTML
<p align="center">[prev-link]<< Previous[/prev-link] {pages} [next-link]Next >>[/next-link]</p>
HTML;


$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Older[/prev-link] ({pages}) [next-link]Newest >>[/next-link]</p>
HTML;


?>