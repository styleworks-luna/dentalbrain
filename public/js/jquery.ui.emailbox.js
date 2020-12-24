/* http://jqueryui.com/demos/autocomplete/combobox.html */
// 폼 검증과 연동하기 위해서는 validate() 호출 다음에 실행할 것
(function( $ ) {
  $.widget( "ui.emailbox", {
    options: {
      positionOptions: {
        my: 'left top'
        ,at: 'left bottom-1'
        ,collision: 'none'
      }
      ,domainList: [
        'naver.com'
        ,'gmail.com'
        ,'hanmail.net'
        ,'nate.com'
        ,'daum.net'
        ,'hotmail.com'
        ,'empal.com'
        ,'korea.com'
        ,'dreamwiz.com'
        ,'paran.com'
        ,'yahoo.com'
        ,'hanmir.com'
        ,'msn.com'
      ]
      ,validate: false
      ,validateRemote: false
      ,triggerChange: false
      ,maxLength: 64
      ,width: null
    },
    _create: function() {
      var o=this.options
        ,self=this
        ,orig_input = this.element
        ,account_input ,domain_input ,domain_handler, validator
        ,wrapper;

      // 전체 요소
      this.wrapper = wrapper = $('<span>')
          .append('<span class="at">@</span>')
          .addClass('ui-'+this.widgetName)
          .insertBefore(this.element);

      // 도메인 이름 정리해 검색용으로 준비
      this.options.predigestedDomainList = this.digestDomainList();

      // 기본 입력칸
      orig_input.hide();
      if (orig_input.attr('maxlength') > 0) {
        o.maxLength = orig_input.attr('maxlength');
      }
      if (typeof orig_input.get(0).form.elements['email']=='undefined') {
        orig_input.attr('name', 'email'); // name 속성이 없으면 검증 내부에서 오류 발생함
      }
      
      // 계정 입력칸
      account_input = $('<input>')
        .attr({
          maxlength: o.maxLength-5
        })
        .addClass(this.widgetFullName+'-account')
        .prependTo(wrapper);

      // 도메인 입력칸
      this.domain = domain_input = $('<input>')
        .attr({
          maxlength: o.maxLength-2
        })
        .addClass(this.widgetFullName+'-domain')
        .appendTo(wrapper)
        .autocomplete({
          delay: 0
          ,minLength: 0 // 전체 목록을 보기 위해서는 0이 되어야 함
          ,source: $.proxy(this.source,this)
          ,position: o.positionOptions
          ,open: function(event, ui) {
            $(this).autocomplete('widget')
              .width( o.width ? o.width : domain_input.outerWidth() + domain_handler.outerWidth() - 3 );
          }
          ,focus: function(event, ui) { return false; } // 이동중에 입력칸 값이 바뀌지 않도록 함
          ,select: function(event, ui) {
            // 값이 실제로 바뀌기 전에 select 이벤트가 발생하고 있어서, 값을 직접 바꾸도록 처리함
            domain_input.val(ui.item.value).trigger('change');
            return false; // 기본 동작을 중단함
          }
        })
        .on('keyup change', function(event) {
          var c=event.keyCode, e=$.ui.keyCode;
          if (event.type=='keyup'
           && !(c==e.PAGE_UP || c==e.PAGE_DOWN || c==e.UP || c==e.DOWN || c==e.TAB || c==e.ENTER || c==e.NUMPAD_ENTER || c==e.ESCAPE) // autocomplete에서 사용하는 동작용 키에 대해서는 자체 처리하지 않음
           && this.value.length > 0 // 변경사항이 있으면 검색
          ) {
            domain_input.autocomplete('search');
          }
        })
        .on('focus', function(event) {
          domain_input.add(domain_handler).addClass('ui-state-focus');
          domain_handler.addClass('ui-state-focus');
        })
        .on('blur', function(event) {
          domain_input.add(domain_handler).removeClass('ui-state-focus');
        })
	      .on('focusout', function(event) {
		      // 값 정리 - 좌우 공란 trim
		      domain_input.val(domain_input.val().replace(/(^\s*)|(\s*$)/gi, ""));
		      orig_input.val( account_input.val() +'@'+ domain_input.val() );
	      });
      // autocomplete 메뉴에 클래스 표시
      domain_input.autocomplete('widget').addClass(this.widgetFullName+'-menu shinyScrollbar');
      // 강조 표시를 처리하기 위해 .text()를 .html()로 변경
      domain_input.data('ui-autocomplete')._renderItem = function(a,b) {
        return $("<li></li>").data("ui-autocomplete-item",b).append($("<a></a>").html(b.label)).appendTo(a)
      }

      // 기본 입력값 지정
      var orig_value = orig_input.val();
      if (orig_value.search('@')>-1) {
        var pair=orig_value.split('@');
        account_input.val( pair[0] );
        domain_input.val( pair[1] );
      }
      account_input.add(domain_input).addClass( orig_input.attr('class') );

      // 자동완성 목록 표시
      domain_handler = $('<a>')
        .attr({
          tabIndex: -1
          //,title: 'Show All Items'
        })
        .appendTo(wrapper)
        .button({
          icons: {
            primary: 'ui-icon-triangle-1-s'
          }
          ,text: false
        })
        .removeClass('ui-corner-all')
        .addClass(this.widgetFullName+'-button ui-button-icon')
        .bind('mouseleave', function(event) {
          if (domain_input.hasClass('ui-state-focus')) {
            domain_handler.addClass('ui-state-focus');
          }
        })
        .bind('click', function() {
          domain_input.addClass('ui-state-focus');

          // close if already visible
          if ( domain_input.autocomplete('widget').is(':visible') ) {
            domain_input.autocomplete('close');
            return;
          }

          // work around a bug (likely same cause as #5265)
          $(this).blur();

          // pass empty string as value to search for, displaying all results
          domain_input.autocomplete('search', '')
            //.focus();
        });

      // 입력칸 변경시 처리
      var repositionTimer=null;
      account_input.add(domain_input).on('keyup change', function(event) {
	      // 두 개로 나뉜 입력칸의 값을 하나로 합침
        orig_input.val( account_input.val() +'@'+ domain_input.val() );
        if (o.triggerChange) {
          orig_input.trigger('change');
        }
        // 검증 실행
        if (o.validate && validator && ((event.type=='keyup' && validator.settings.onkeyup) || (event.type=='change' && (validator.settings.onfocusout)))) {
          validator.element(orig_input);
          // 검증 실행에 의해 화면이 변경되었을 수 있으므로 메뉴 위치 재조정
          repositionTimer && clearTimeout(repositionTimer);
          repositionTimer = setTimeout(function() {
            domain_input.autocomplete('widget').filter(':visible')
              .position({
                my: o.positionOptions.my || 'left top'
                ,at: o.positionOptions.at || 'left bottom'
                ,of: domain_input
                ,collision: 'none' // 화면이 작을 때 
              });
          }, 100);
        }
      }).on('focusout', function(event){
	      // 값 정리 - 좌우 공란 trim
	      account_input.val(account_input.val().replace(/(^\s*)|(\s*$)/gi, ""));
	      orig_input.val( account_input.val() +'@'+ domain_input.val() );
      });

      // 문서 임의 위치를 지정하면 메뉴 닫음
      $(document).bind('mousedown.'+this.widgetName, function(event) {
        if ( $.contains(domain_input.autocomplete('widget').get(0),event.target)
          || domain_input.autocomplete('widget').filter(event.target).length > 0
          || $.contains(domain_handler.get(0),event.target)
          || domain_handler.filter(event.target).length > 0
        ) {
          return;
        }
        domain_input.autocomplete('close')
          .add(domain_handler).removeClass('ui-state-focus');
      });

      // jQuery Validate 모듈이 있을 경우 자체 검증을 위한 규칙 추가
      validator = $.data(this.element.get(0).form, 'validator');
      if (typeof validator == 'undefined') {
        o.validate = false;
      } else {
        // 제외 조건 추가
        validator.settings.ignore = validator.settings.ignore + ',.'+this.widgetFullName+'-account,.'+this.widgetFullName+'-domain';
        // 규칙 추가
        orig_input.rules('add', {
          required: true
          ,email: true
          ,messages: {
            required: '이메일을 입력해 주세요.'
            ,email: '이메일 형식에 맞게 입력해 주세요.'
          }
        });
        if (o.validateRemote) {
          orig_input.rules('add', {
            remote: {
              url: '/_/xmlProxy/xmlProxy.ofm'
              ,type: 'post'
              ,data: {
                url: base_apiUrl+'/account/checkEmail'
                ,output: 'json'
                ,email: function() { return orig_input.val(); }
              }
              ,beforeSend: function(xhr, settings) {
                // 기본 출력값과 같으면 검증 없이 통과 (모임개설 등에 사용될 때 불필요한 검증 및 검증오류 배제)
                if (orig_input.val() == orig_input.get(0).defaultValue) {
                  validator.stopRequest(orig_input.get(0),false);
                  if (orig_input.get(0).form.elements['checkEmail']) {
                    $(orig_input.get(0).form.elements['checkEmail']).val('1').valid();
                  }
                  return false;
                }
              }
              ,error: function(status, xhr) {
                if (status == 'timeout') {
                  alert('서버와의 연결이 원활하지 않습니다. 잠시후에 다시 시도해주세요.');
                } else if (status == 'parsererror') {
                  alert('서버의 동작이 원활하지 않습니다. 잠시후에 다시 시도해주세요.');
                }
              }
              ,complete: function(data, status, request) {
                // 성공적으로 끝나지 않았으면 호출 시작시에 표시됐던 값을 제거하여 강제 재호출 가능하도록 함
                if (status!='success') validator.stopRequest(orig_input.get(0),false);
                if (orig_input.valid()) orig_input.trigger('valid-form'); else orig_input.trigger('invalid-form');
                // 검증값 기록
                if (orig_input.get(0).form.elements['checkEmail']) {
                  $(orig_input.get(0).form.elements['checkEmail']).val( orig_input.valid()?'1':'0' ).valid();
                }
              }
              ,timeout: 10000
            }
          });
        }
        /*
        account_input.rules('add', {
          required: true
          ,messages: {
            required: '이메일을 입력해 주세요.'
          }
        });
        domain_input.rules('add', {
          required: true
          ,messages: {
            required: '이메일을 입력해 주세요.'
          }
        });
        */
        /*
        if ($.validator.methods.emailAccount) {
          account_input.rules('add', {
            emailAccount: true
            ,messages: {
              emailAccount: '이메일 형식에 맞게 입력해 주세요.'
            }
          });
        }
        if ($.validator.methods.emailDomain) {
          domain_input.rules('add', {
            emailDomain: true
            ,messages: {
              emailAccount: '이메일 형식에 맞게 입력해 주세요.'
            }
          });
        }
        */
        // 원래 요소에 대한 오류를 신규 입력칸 기준으로 표시
        var id=this.widgetFullName.concat('-',new Date().getTime());
        account_input.attr('id', id.concat('-account'));
        domain_input.attr('id', id.concat('-domain'));
        //validator.groups[ orig_input.attr('name') ] = id;
        //validator.groups[ domain_input.attr('id') ] = id;
      }
    }

    // 제시된 도메인 목록에서 일부만 검색 대상으로 지정
    ,source: function(data, buildMenu) {
      var list=this.options.domainList
         ,digested=this.options.predigestedDomainList
         ,retrieved=[]
         ,keyword=data.term
         ,menu=this.domain.autocomplete('widget');
      // 검색
      $.each(digested, function(i, value) {
        var d=digested[i], v=list[i], l;
        if (d.indexOf(keyword)>-1) {
          if (keyword.length>0) {
            l=v.replace(keyword,'<em>'+keyword+'</em>');
          }
          retrieved[retrieved.length]={label:l, value:v};
        }
      });
      // 구성된 결과로 메뉴 표시
      buildMenu(retrieved);
    }

    ,_setOption: function(key, value) {
      if (key=='domainList') {
        this.options.predigestedDomainList = this.digestDomainList();
      }
      $.Widget.prototype._setOption.apply(this, arguments);
    }

    // 도메인 이름 중 TLD 등을 제외하고 검색에 사용할 값만 따로 기억
    ,digestDomainList: function(domainList) {
      var list=this.options.domainList
         ,digest=[];
      $.each(list, function(i, name) {
        // TLD 및 그 하부 도메인에 대해 모두 나열할 수는 없으므로 일단 일부만 처리
        if (name.lastIndexOf('.com')==name.length-4) {
          name = name.substring(0,name.length-4);
        } else if (name.lastIndexOf('.net')==name.length-4) {
          name = name.substring(0,name.length-4);
        } else if (name.lastIndexOf('.co.kr')==name.length-6) {
          name = name.substring(0,name.length-6);
        }
        digest[i] = name;
      });
      return digest;
    }

    ,destroy: function() {
      this.wrapper.remove();
      this.element.show();
      $.Widget.prototype.destroy.call( this );
    }
  });
})( jQuery );