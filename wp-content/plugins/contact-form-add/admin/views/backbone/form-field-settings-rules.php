<% if ( type !== 'pagebreak' ) { %>
<div class="panel-group" id="fieldRulesCont">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapseRules<%= cssID %>">
          <?php smuzform_translate_e( 'Conditional Logic' ) ?>
        </a>
      </h4>
    </div>
    <div id="collapseRules<%= cssID %>" class="panel-collapse collapse">
      <div class="panel-body">
          
        <div id="ruleBuilderCont">
          
          <label>

         <?php if ( version_compare(  '1.7' , get_option( 'smuzform_plugin_version' )  ) === 1 ): ?>

            <input type="checkbox" id="enableConditionalLogic" <% if ( ruleEnabled === true ) { %> <%- 'checked' %> <% } %> /> <?php smuzform_translate_e( 'Enable' ) ?>

          <?php else: ?>

            <p class="description"><h4><a href="http://web-settler.com/form-builder/?ref=logic" target="_blank"><?php smuzform_translate_e( 'Purchase premium version to unlock Conditional Logic.' ) ?></a></h4></p>

            <input type="checkbox" disabled > <?php smuzform_translate_e( 'Enable' ) ?>

          <?php endif; ?>


          </label>

          <ul id="rules">
            
            <li>
              
              <div class="rule">

                <div class="ruleInlineCont">
                  <strong>If</strong>

                  <select id="ruleFields">
                     <option value="">Select a field</option>
                    <% _.each(smuzform.App.Collections.FieldsCol.toJSON(), function(model) { %>
                   
                    <% if ( model.cssID !== cssID ) { %>
                    
                    <% if ( model.type !== 'address' && model.type !== 'sectionbreak' && model.type !== 'name' && model.type !== 'fileupload' && model.type !== 'checkbox' && model.type !== 'customText' && model.type !== 'customHtml' && model.type !== 'customImage' && model.type !== 'customLink' && model.type !== 'pagebreak' ) { %>
                    <option <% if ( rules.field === model.cssID ) { %> <%- 'selected' %> <% } %> value="<%- model.cssID %>"><%- model.label %></option>
                    
                    <% } %>

                    <% } %>

                    <% }); %>

                  </select>

                  <select id="ruleFieldOperator">

                    <option <% if ( rules.operator === 'is' ) { %> <%- 'selected' %> <% } %> value="is">Is</option>
                    <option <% if ( rules.operator === 'isNot' ) { %> <%- 'selected' %> <% } %> value="isNot">Is not</option>

                  </select>
                </div>

                <div class="ruleInlineCont">
                  <input type="text" value="<%- rules.cmpValue %>" id="ruleFieldLogicValue" placeholder="Enter comparison value" />

                  <select id="ruleFieldAction">

                    <option <% if ( rules.action === 'show' ) { %> <%- 'selected' %> <% } %> value="show">Show</option>
                    <option <% if ( rules.action === 'hide' ) { %> <%- 'selected' %> <% } %> value="hide">Hide</option>

                  </select>
                </div>


              </div>

            </li>

          </ul>

        </div>

      </div>
      
      <div class="panel-footer">
        <small>If the current field is *required logic may not work.</small>
      </div>

    </div>
  </div>
</div>
<% } %>