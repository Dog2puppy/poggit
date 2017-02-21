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

namespace poggit\module\build;

use poggit\module\Module;
use poggit\utils\internet\CurlUtils;
use poggit\utils\SessionUtils;

class FqnModule extends Module {
    public function getName(): string {
        return "fqn";
    }

    public function output() {
        ?>
        <html>
        <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile#">
            <title>Global Class Index | Poggit</title>
            <?php $this->headIncludes("Global Class Index", "Find all namespaces and classes we have seen, and the plugins using them. You can also see a list of namespaces used by other plugins, so make sure your plugin isn't using other plugins' namespaces.") ?>
            <script>
                function initNode(div, ns) {
                    div.addClass("fqn-node");
                    div.addClass("fqn-node-loading");
                    div.text("Loading...");
                    ajax("fqn.ls", {
                        data: {ns: ns},
                        success: function(data) {
                            div.attr("data-ns", ns);
                            div.removeClass("fqn-node-loading");
                            for(var i = 0; i < data.length; i++) {
                                if(data[i].type == "ns") {
                                    var sub = $("<div></div>");
                                    var p = $("<p></p>");
                                    var inner = $("<div></div>");
                                    p.text(data[i].name);
                                    var expand = $("<span class='action'>+</span>");
                                    expand.click(function() {
                                        initNode(inner, data[i].name);
                                    });
                                    expand.appendTo(p);
                                    p.appendTo(sub);
                                    inner.appendTo(sub);
                                    sub.appendTo(div);
                                }
                            }
                        }
                    });
                }
                $(document).ready(function() {
                    initNode($("#node-root"), "");
                });
            </script>
        </head>
        <body>
        <?php $this->bodyHeader() ?>
        <div id="body">
            <h1>Global Class Index</h1>
            <div id="node-root"></div>
            <p class="remark"></p>
        </div>
        <?php $this->bodyFooter() ?>
        </body>
        </html>
        <?php
    }
}
