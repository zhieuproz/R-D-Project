(function () {
  tinymce.create('tinymce.plugins.gmwd_mce', {
    init:function (ed, url) {
      var c = this;
      c.url = url;
      c.editor = ed;
      ed.addCommand('mcegmwd_mce', function () {
        ed.windowManager.open({
          file:gmwd_admin_ajax,
          width:1000 + ed.getLang('gmwd_mce.delta_width', 0),
          height:400 + ed.getLang('gmwd_mce.delta_height', 0),
          inline:1
        }, {
          plugin_url:url
        });
        var e = ed.selection.getNode(), d = wp.media.gallery, f;
        if (typeof wp === "undefined" || !wp.media || !wp.media.gallery) {
          return
        }
        if (e.nodeName != "IMG" || ed.dom.getAttrib(e, "class").indexOf("gmwd_shortcode") == -1) {
          return
        }
        f = d.edit("[" + ed.dom.getAttrib(e, "title") + "]");
      });
      ed.addButton('gmwd_mce', {
        title:'Insert Google Map WD',
        cmd:'mcegmwd_mce',
        image: url + '/icon-map-20.png'
      });
      ed.onMouseDown.add(function (d, f) {
        if (f.target.nodeName == "IMG" && d.dom.hasClass(f.target, "gmwd_shortcode")) {
          var g = tinymce.activeEditor;
          g.wpGalleryBookmark = g.selection.getBookmark("simple");
          g.execCommand("mcegmwd_mce");
        }
      });
      ed.onBeforeSetContent.add(function (d, e) {
        e.content = c._do_gmwd(e.content)
      });
      ed.onPostProcess.add(function (d, e) {
        if (e.get) {
          e.content = c._get_gmwd(e.content)
        }
      })
    },
    _do_gmwd:function (ed) {
      return ed.replace(/\[Google_Maps_WD([^\]]*)\]/g, function (d, c) {
                        
        return '<img src="' + gmwd_plugin_url +'/images/icon-map-50.png" class="gmwd_shortcode mceItem" title="Google_Maps_WD' + tinymce.DOM.encode(c) + '" alt="Google_Maps_WD' + tinymce.DOM.encode(c) + '" />';
      })
    },
    _get_gmwd:function (b) {
      function ed(c, d) {
        d = new RegExp(d + '="([^"]+)"', "g").exec(c);
        return d ? tinymce.DOM.decode(d[1]) : "";
      }

      return b.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function (e, d) {
        var c = ed(d, "class");
        if (c.indexOf("gmwd_shortcode") != -1) {
          return "<p>[" + tinymce.trim(ed(d, "title")) + "]</p>"
        }
        return e
      })
    }
  });
  tinymce.PluginManager.add('gmwd_mce', tinymce.plugins.gmwd_mce);
})();