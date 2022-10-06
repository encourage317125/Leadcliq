<div class="container form-wizard">
    <div class="row">
        <div class="modal-box modal-box-shadow col-md-10 col-md-offset-1">
            <div class="modal-box modal-box-2">
                <div class="profile-modal modal-box modal-box-2">
                    <div class="profile-modal-header">
                        <h2 class="profile-modal-header-title"><span class="title-step">Step 3</span>Sales Territory</h2>
                    </div>
                    <div class="profile-modal-body" data-ng-app="Leadcliq">

                        <div id="searchTerritoriesNew" data-ng-controller="TerritoriesCtrlNew">
                            <form data-ng-submit="searchForTerritory()" class="well">
                                <h4>Search for Sales Territories to Add</h4>
                                <br/>
                                <div class="input-group">
                                    <input type="text" class="form-control" data-ng-model="searchTerritory" data-ng-change="clearPossibleMatches()" placeholder="Search by cities, states, countries, etc." ng-disabled="searchingForTerritory">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-lg" type="submit" value="submit" ng-disabled="searchingForTerritory">
                                            <span class="glyphicon glyphicon-search" data-ng-show="!searchingForTerritory"></span>
                                            <span class="glyphicon glyphicon-refresh spin" data-ng-show="searchingForTerritory"></span>
                                        </button>
                                    </span>
                                </div><!-- /input-group -->
                            </form>

                            <br/>
                            <div id="mutlipleTerritoriesFound" data-ng-show="possibleMatchTerritories.length>1">
                                <h4>
                                    Multiple Matches Found
                                </h4>
                                <br/>
                                <table class="table">
                                    <tbody>
                                    <tr data-ng-repeat="territory in possibleMatchTerritories">
                                        <td>
                                            <span class="name">[[territory.name]]</span>
                                        </td>
                                        <td class="controls-right">
                                            <a class="btn" data-ng-click="addTerritory(territory)" data-ng-show="!thisTerritoryBeingAdded(territory)">
                                                <i class="glyphicon glyphicon-plus"></i> Add
                                            </a>
                                            <a class="btn disabled" data-ng-show="thisTerritoryBeingAdded(territory)">Adding...</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="listTerritories" data-ng-show="allTerritories.length>0">
                                <h2>Added Sales Territories</h2>
                                <br/>
                                <table class="table">
                                    <tbody>
                                    <tr data-ng-repeat="territory in allTerritories">
                                        <td>
                                            <span class="name">[[territory.name]]</span>
                                        </td>
                                        <td class="controls-right">
                                            <a class="btn" data-ng-click="deleteUserTerritory(territory)">
                                                <i class="glyphicon glyphicon-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div id="map" style="width: 550px; height: 350px; display: none;"></div>
                            <div id="areapolygon"></div>
                            <div id="areapolygon2"></div>
                            <div id="areapolygon3"></div>
                            <div id="areapolygon4"></div>


                        </div>
                        <div class="profile-modal-footer">
                            <div class="row">
                                <div class="col-sm-2">
                                    <button class="btn btn-default btn-lg" onclick="showPrevStep(4)">PREVIOUS</button>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="slide-step list-unstyled list-inline">
                                        <li><span class="step"></span></li>
                                        <li><span class="step"></span></li>
                                        <li><span class="step active"></span></li>
                                        <li><span class="step"></span></li>
                                    </ul>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-lg pull-right" onclick="showNextStep(4)">NEXT <i class="icon-arrow"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="uid" class="hide">{{ Sentry::getUser()->id }}</div>
</div>