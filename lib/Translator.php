<?php
class T {
    public static function translate($k) {
        $v = $k;
        switch ($k) {
            case 'adds': $v = 'Adds'; break;
            case 'rems': $v = 'Removes'; break;
            case 'kills': $v = 'Kills'; break;
            case 'deaths': $v = 'Deaths'; break;
            case 'matches': $v = 'Matches'; break;
            case 'wins': $v = 'Wins'; break;
            case 'losses': $v = 'Losses'; break;
            case 'desertions': $v = 'Deserted a match'; break;
            case 'substituted': $v = 'Substituted into a match'; break;
            case 'substitutions': $v = 'Substituted into a match'; break;
            case 'substitutions_requested': $v = 'Requested a sub'; break;

            case 'builder.kills': $v = 'Kills as Builder'; break;
            case 'builder.deaths': $v = 'Deaths as Builder'; break;
            case 'builder.matches': $v = 'Matches as Builder'; break;
            case 'builder.wins': $v = 'Wins as Builder'; break;
            case 'builder.losses': $v = 'Losses as Builder'; break;

            case 'archer.kills': $v = 'Kills as Archer'; break;
            case 'archer.deaths': $v = 'Deaths as Archer'; break;
            case 'archer.matches': $v = 'Matches as Archer'; break;
            case 'archer.wins': $v = 'Wins as Archer'; break;
            case 'archer.losses': $v = 'Losses as Archer'; break;

            case 'knight.kills': $v = 'Kills as Knight'; break;
            case 'knight.deaths': $v = 'Deaths as Knight'; break;
            case 'knight.matches': $v = 'Matches as Knight'; break;
            case 'knight.wins': $v = 'Wins as Knight'; break;
            case 'knight.losses': $v = 'Losses as Knight'; break;

            case 'kills.gibbed': $v = 'Killed with bombs'; break;
            case 'kills.hammered': $v = 'Killed with hammer'; break;
            case 'kills.assisted':
            case 'kills.died':
                $v = 'Killed with falling rocks'; break;
            case 'kills.shot': $v = 'Shot with an arrow'; break;
            case 'kills.slew': $v = 'Slew with their sword'; break;
            case 'kills.squashed': $v = 'Stomped someone to death'; break;
            case 'kills.pushed': $v = 'Pushed someone off a ledge'; break;
            case 'kills.fell': $v = 'Pushed someone to their death'; break;

            case 'deaths.assisted':
            case 'deaths.died':
                $v = 'Crushed under falling rocks'; break;
            case 'deaths.gibbed': $v = 'Died by a bomb'; break;
            case 'deaths.hammered': $v = 'Died by being hammered'; break;
            case 'deaths.shot': $v = 'Shot by an Archer'; break;
            case 'deaths.slew': $v = 'Slain by a Knight'; break;
            case 'deaths.squashed': $v = 'Stomped to death'; break;
            case 'deaths.pushed': $v = 'Pushed off a ledge'; break;
            case 'deaths.fell': $v = 'Fell to their death'; break;
            case 'deaths.cyanide': $v = 'Committed suicide'; break;

        }
        return $v;
    }
}