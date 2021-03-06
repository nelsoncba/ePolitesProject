angular.module('Polites')
        .directive('ddTextCollapse', ['$compile', function($compile) {
        return {
            restrict: 'A',
            scope: true,
            link: function(scope, element, attrs) {

                // start collapsed
                scope.collapsed = false;

                // create the function to toggle the collapse
                scope.toggle = function() {
                    scope.collapsed = !scope.collapsed;
                };

                // wait for changes on the text
                attrs.$observe('ddTextCollapseText', function(text) {

                    // get the length from the attributes
                    var maxLength = scope.$eval(attrs.ddTextCollapseMaxLength);

                    if (text.length > maxLength) {
                        // split the text in two parts, the first always showing
                        var firstPart = String(text).substring(0, maxLength);
                        var secondPart = String(text).substring(maxLength, text.length);

                        // create some new html elements to hold the separate info
                        var firstSpan = $compile('<span>' + firstPart + '</span>')(scope);
                        var secondSpan = $compile('<span ng-if="collapsed">' + secondPart +'</span>')(scope);
                        var moreIndicatorSpan = $compile('<span ng-if="!collapsed">... </span>')(scope);
                        var lineBreak = $compile('<br ng-if="collapsed">')(scope);
                        var toggleButton = $compile('<span class="collapse-text-toggle" ng-click="toggle()">{{collapsed ? "" : "ver mas"}}</span>')(scope);

                        // remove the current contents of the element
                        // and add the new ones we created
                        element.empty();
                        element.append(firstSpan);
                        element.append(secondSpan);
                        element.append(moreIndicatorSpan);
                        element.append(lineBreak);
                        element.append(toggleButton);
                    }
                    else {
                        element.empty();
                        element.append(text);
                    }
                });
            }
        };
    }])
    //ajustar input commentarios y respuestas
    .directive('elastic', function() {
        return {
            restrict: 'A',
            link: function( $scope, elem, attrs) {
                
                elem.bind('keyup change', function($event) {
                    var element = $event.target;
                    $(element).height(-1);
                    $(element).height($(element)[0].scrollHeight);

                });
            }
        };
    })
    .directive("timeago", function($compile) {
      return {  
        restrict: "C",
        link: function(scope, element, attrs) {
          jQuery(element).timeago();
        }
      };
    })
    .directive('tagsInput', function () {
        return {
            restrict: 'A',
            link: function (scope, Element, Attrs) {
                var tags = new Bloodhound({
                  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('tag'),
                  queryTokenizer: Bloodhound.tokenizers.whitespace,
                  prefetch: {
                    url: './api/tags',
                    filter: function(data) {
                      return data;
                    }
                  }
                });
                tags.initialize();

                jQuery(Element).tagsinput({
                   maxTags:4,
                   typeaheadjs: {
                    name: 'tags',
                    displayKey: 'tag',
                    valueKey: 'tag',
                    source: tags.ttAdapter()
                  }
                });
            }
        };
    })
    .directive('scrollMode', [function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                    element.on('click', function(){
                    var scrollAnchor = attrs.scrollto;
                    scrollPoint = $('[anchor="'+scrollAnchor+'"]').offset().top - 50;
                    angular.element('body, html').animate({
                        scrollTop: scrollPoint
                    }, 500);
                })
            }
        };
    }]);