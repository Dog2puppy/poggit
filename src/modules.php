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

namespace poggit;

use poggit\module\ajax\CsrfModule;
use poggit\module\ajax\GitHubApiProxyAjax;
use poggit\module\ajax\LogoutAjax;
use poggit\module\ajax\PersistLocAjax;
use poggit\module\ajax\SearchBuildAjax;
use poggit\module\ajax\ReleaseAdmin;
use poggit\module\ajax\ReviewAdmin;
use poggit\module\ajax\SuAjax;
use poggit\module\api\ApiModule;
use poggit\module\build\AbsoluteBuildIdModule;
use poggit\module\build\BuildImageModule;
use poggit\module\build\BuildModule;
use poggit\module\build\FqnModule;
use poggit\module\build\FqnAjax;
use poggit\module\build\FqnListModule;
use poggit\module\build\LoadBuildHistoryAjax;
use poggit\module\build\GetPmmpModule;
use poggit\module\build\ReadmeBadgerAjax;
use poggit\module\build\ScanRepoProjectsAjax;
use poggit\module\build\ToggleRepoAjax;
use poggit\module\debug\AddResourceModule;
use poggit\module\debug\AddResourceReceive;
use poggit\module\help\HelpModule;
use poggit\module\help\HideTosModule;
use poggit\module\help\LintsHelpModule;
use poggit\module\help\PrivateResourceHelpModule;
use poggit\module\help\ReleaseSubmitHelpModule;
use poggit\module\help\TosModule;
use poggit\module\home\NewHomeModule;
use poggit\module\LoginModule;
use poggit\module\ProxyLinkModule;
use poggit\module\releases\index\ReleaseListModule;
use poggit\module\releases\project\ProjectReleasesModule;
use poggit\module\releases\review\ReviewListModule;
use poggit\module\releases\RelSubValidateAjax;
use poggit\module\releases\submit\PluginSubmitAjax;
use poggit\module\releases\submit\SubmitPluginModule;
use poggit\module\res\JsModule;
use poggit\module\res\ResModule;
use poggit\module\resource\ResourceGetModule;
use poggit\module\RobotsTxtModule;
use poggit\module\SettingsModule;
use poggit\module\webhooks\GitHubLoginCallbackModule;
use poggit\module\webhooks\repo\NewGitHubRepoWebhookModule;

registerModule(CsrfModule::class);
registerModule(LogoutAjax::class);
registerModule(SuAjax::class);
registerModule(PersistLocAjax::class);
registerModule(GitHubApiProxyAjax::class);

registerModule(NewHomeModule::class);
registerModule(LoginModule::class);
registerModule(SettingsModule::class);

registerModule(ApiModule::class);

registerModule(BuildModule::class);
registerModule(AbsoluteBuildIdModule::class);
registerModule(GetPmmpModule::class);
registerModule(BuildImageModule::class);
registerModule(FqnModule::class);
registerModule(FqnListModule::class);
registerModule(ScanRepoProjectsAjax::class);
registerModule(SearchBuildAjax::class);
registerModule(ReleaseAdmin::class);
registerModule(ReviewAdmin::class);
registerModule(ToggleRepoAjax::class);
registerModule(RelSubValidateAjax::class);
registerModule(LoadBuildHistoryAjax::class);
registerModule(ReadmeBadgerAjax::class);

registerModule(ReleaseListModule::class);
registerModule(ProjectReleasesModule::class);
registerModule(ReviewListModule::class);

registerModule(SubmitPluginModule::class);
registerModule(PluginSubmitAjax::class);
//registerModule(dep_PluginSubmitCallbackModule::class);

registerModule(HelpModule::class);
registerModule(PrivateResourceHelpModule::class);
registerModule(LintsHelpModule::class);
registerModule(ReleaseSubmitHelpModule::class);
registerModule(TosModule::class);
registerModule(HideTosModule::class);

registerModule(RobotsTxtModule::class);
registerModule(ProxyLinkModule::class);
registerModule(ResModule::class);
registerModule(JsModule::class);

registerModule(GitHubLoginCallbackModule::class);
registerModule(NewGitHubRepoWebhookModule::class);

registerModule(ResourceGetModule::class);

if(Poggit::isDebug()) {
    registerModule(AddResourceModule::class);
    registerModule(AddResourceReceive::class);
}
