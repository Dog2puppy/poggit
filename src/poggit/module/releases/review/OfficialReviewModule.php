<?php

/*
 * Poggit
 *
 * Copyright (C) 2016-2017 Poggit
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace poggit\module\releases\review;

use poggit\module\Module;
use poggit\utils\internet\MysqlUtils;
use poggit\utils\SessionUtils;
use poggit\Poggit;
use poggit\release\PluginRelease;

class OfficialReviewModule extends Module {
    
    const SHOW_REVIEWS_IN_RELEASE = false;
    
    public static function storeReview($releaseId, $user, $criteria, $type, $cat, $score, $message): int {

        $reviewId = MysqlUtils::query("INSERT INTO release_reviews (releaseId, user, criteria, type, cat, score, message)"
                . " VALUES (?, ?, ?, ?, ?, ?, ?)", "iiiiiis", $releaseId, $user, $criteria, $type, $cat, $score, $message);
        return $reviewId;
    }
    
    public static function deleteReview(): int {
        $user = SessionUtils::getInstance()->getLogin("Name") ?? "";
        if (Poggit::getAdmlv($user) > Poggit::MODERATOR || $user == $username) {
        $reviewId = MysqlUtils::query("DELETE FROM release_reviews WHERE (releaseId, user)"
                    . " VALUES (?, ?)", "ii", $releaseId, $user);           
        }
        return $reviewId;
    }
 
    public static function getNameFromUID(int $uid): string {
        $username = MysqlUtils::query("SELECT name FROM users WHERE uid = ?", "i", $uid);
        return count($username) > 0 ? $username[0]["name"] : "Unknown";
    }
    
    public static function getUsedCriteria(int $relId, int $uid): array {
        $usedCategories = MysqlUtils::query("SELECT * FROM release_reviews WHERE (releaseId = ? AND user = ?)", "ii", $relId, $uid);
        return $usedCategories;
    }
    
    public static function getUIDFromName(string $name): int {
        $uid = MysqlUtils::query("SELECT uid FROM users WHERE name = ?", "s", $name);
        return count($uid) > 0 ? $uid[0]["uid"] : 0;
    }

    public function output() {
        // TODO: Implement output() method.
    }
    
    public static function reviewPanel($relIds, string $user, bool $showRelease = false) {
     
        foreach ($relIds as $relId) {
          
        $reviews = MysqlUtils::query("SELECT * FROM release_reviews WHERE releaseId = ? ORDER BY type", "i", $relId ?? 0);
        $releaseName = MysqlUtils::query("SELECT name FROM releases WHERE releaseId = ? LIMIT 1", "i", $relId ?? "");
            foreach ($reviews as $review) { ?>
            <div class="review-outer-wrapper-<?= Poggit::getAdmlv(self::getNameFromUID($review["user"])) ?? "0" ?>">
                    <div class="review-author review-info-wrapper">
                        <div><h3><a href="<?= Poggit::getRootPath() . "p/" . $releaseName[0]["name"] . "/" . $review["releaseId"] ?>"><?= $showRelease ? $releaseName[0]["name"] : "" ?></a></h3></div>
                            <div id ="reviewer" value="<?= $review["user"] ?>" class="review-header"><h3><?= self::getNameFromUID($review["user"]) ?></h3>
                                <?php if (self::getNameFromUID($review["user"]) == $user || Poggit::getAdmlv($user) > Poggit::MODERATOR) { ?>
                                <div class="action review-delete" onclick="deleteReview(this)" value="<?= $review["releaseId"] ?>">x</div>
                            <?php } ?>
                            </div>
                    <div class="review-panel-left">
                            <div class="review-score review-info"><?= $review["score"] ?>/5</div>
                            <div class="review-type review-info"><?= PluginRelease::$REVIEW_TYPE[$review["type"]] ?></div>
<!--                        <div class="review-cat review-info">Category: <?= $review["cat"] ?></div>-->
                            <div <?= Poggit::getAdmlv(self::getNameFromUID($review["user"])) < Poggit::MODERATOR ? "hidden='true'" : "" ?> id="criteria" class="review-criteria review-info" value="<?= $review["criteria"] ?? 0 ?>"><?= PluginRelease::$CRITERIA_HUMAN[$review["criteria"] ?? 0]?></div>
                    </div>
                    </div>
                    <div class="review-panel-right plugin-info">
                    <span class="review-message"><?= $review["message"] ?></span>
                    </div>
            </div>
            <?php
            }
        }  
    }
     
    public function getName(): string {
        return "admin.pluginReview";
    }
}
