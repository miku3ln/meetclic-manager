<?php
interface BusinessByGamificationRepositoryInterface {
    public function getBusinessIdByGamificationId(int $gamificationId): int;
}

?>
