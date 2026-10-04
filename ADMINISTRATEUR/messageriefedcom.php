<?php
include_once 'recupererMail.php';
$Mail = recuperer_mail();
?>

<li class="nav-item dropdown no-arrow mx-1"> <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        <span class="badge badge-danger badge-counter">
            <?php
            if (isset($Mail['mail'])) {
                $vu = 0;
                for ($i = 0; $i < $Mail['InfoMail']->Nmsgs - 1; $i++) {
                    if ($Mail['mail'][$i]->seen == 0) {
                        $vu = $vu + 1;
                    }
                }
                echo $vu;
            } else {
                echo "nb";
            }
            ?>
        </span>
    </a>
    <!-- Dropdown - Messages -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
        <h6 class="dropdown-header">
            Centre de messagerie
        </h6>
        <!-- les message -->
        <?php
        if (isset($Mail['mail'])) {
            $index = $Mail['InfoMail']->Nmsgs - 1;
            for ($i = 0; $i < $Mail['InfoMail']->Nmsgs - 1; $i++) {
                $sujet = utf8_decode(imap_utf8($Mail['mail'][$index]->subject));
                $date = utf8_decode(imap_utf8($Mail['mail'][$index]->date));
                $from = utf8_decode(imap_utf8($Mail['mail'][$index]->from));
                if ($Mail['mail'][$index]->seen == 0) {
                    $seen = '';
                } else {
                    $seen = 'class="font-weight-bold"';
                }
                echo '<a class="dropdown-item d-flex align-items-center" target="_blank" href="messagePreview.php?id=' . $index . '">
        <div class="dropdown-list-image mr-3">
        <img class="rounded-circle" src="imge/undraw_profile_1.svg" alt="...">
        <div class="status-indicator bg-success"></div>
        </div>
        <div ' . $seen . '>
        <div class="text-truncate">' . $sujet . '</div>
        <div class="small text-gray-500">' . $from . '  ' . $date . '  ' . '</div>
        </div>
        </a>';
                $index = $index - 1;
            }
        } else {
            echo '<a class="dropdown-item d-flex align-items-center"  href="404.php">
    <div class="dropdown-list-image mr-3">
    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
    <div class="status-indicator bg-success"></div>
    </div>
    <div class="font-weight-bold">
    <div class="text-truncate">message</div>
    <div class="small text-gray-500">John 15h</div>
    </div>
    </a>';
        }
        ?>
    </div>
</li>