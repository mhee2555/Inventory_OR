!(function (e, i) {
  "function" == typeof define && define.amd
    ? define(["jquery"], i)
    : "object" == typeof exports
    ? (module.exports = i(require("jquery")))
    : (e.Dropify = i(e.jQuery));
})(this, function (e) {
  function i(i, t) {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
      var s = {
        defaultFile: "",
        maxFileSize: 0,
        minWidth: 0,
        maxWidth: 0,
        minHeight: 0,
        maxHeight: 0,
        showRemove: !0,
        showLoader: !0,
        showErrors: !0,
        errorTimeout: 3e3,
        errorsPosition: "overlay",
        imgFileExtensions: ["png", "jpg", "jpeg", "gif", "bmp"],
        maxFileSizePreview: "5M",
        allowedFormats: ["portrait", "square", "landscape"],
        allowedFileExtensions: ["*"],
        messages: {
          default: "Drag and drop a file here or click",
          replace: "Drag and drop or click to replace",
          remove: "Remove",
          error: "Ooops, something wrong appended.",
        },
        error: {
          fileSize: "The file size is too big ({{ value }} max).",
          minWidth: "The image width is too small ({{ value }}}px min).",
          maxWidth: "The image width is too big ({{ value }}}px max).",
          minHeight: "The image height is too small ({{ value }}}px min).",
          maxHeight: "The image height is too big ({{ value }}px max).",
          imageFormat: "The image format is not allowed ({{ value }} only).",
          fileExtension: "The file is not allowed ({{ value }} only).",
        },
        tpl: {
          wrap: '<div class="dropify-wrapper"></div>',
          loader: '<div class="dropify-loader"></div>',
          message:
            '<div class="dropify-message"><span class="file-icon" /> <p>{{ default }}</p></div>',
          preview:
            '<div class="dropify-preview"><span class="dropify-render"></span><div class="dropify-infos"><div class="dropify-infos-inner"><p class="dropify-infos-message">{{ replace }}</p></div></div></div>',
          filename:
            '<p class="dropify-filename"><span class="file-icon"></span> <span class="dropify-filename-inner"></span></p>',
          clearButton:
            '<button type="button" class="dropify-clear">{{ remove }}</button>',
          errorLine: '<p class="dropify-error">{{ error }}</p>',
          errorsContainer:
            '<div class="dropify-errors-container"><ul></ul></div>',
        },
      };
      (this.element = i),
        (this.input = e(this.element)),
        (this.wrapper = null),
        (this.preview = null),
        (this.filenameWrapper = null),
        (this.settings = e.extend(!0, s, t, this.input.data())),
        (this.errorsEvent = e.Event("dropify.errors")),
        (this.isDisabled = !1),
        (this.isInit = !1),
        (this.file = {
          object: null,
          name: null,
          size: null,
          width: null,
          height: null,
          type: null,
        }),
        Array.isArray(this.settings.allowedFormats) ||
          (this.settings.allowedFormats =
            this.settings.allowedFormats.split(" ")),
        Array.isArray(this.settings.allowedFileExtensions) ||
          (this.settings.allowedFileExtensions =
            this.settings.allowedFileExtensions.split(" ")),
        (this.onChange = this.onChange.bind(this)),
        (this.clearElement = this.clearElement.bind(this)),
        (this.onFileReady = this.onFileReady.bind(this)),
        this.translateMessages(),
        this.createElements(),
        this.setContainerSize(),
        (this.errorsEvent.errors = []),
        this.input.on("change", this.onChange);
    }
  }
  var t = "dropify";
  return (
    (i.prototype.onChange = function () {
      this.resetPreview(), this.readFile(this.element);
    }),
    (i.prototype.createElements = function () {
      (this.isInit = !0),
        this.input.wrap(e(this.settings.tpl.wrap)),
        (this.wrapper = this.input.parent());
      var i = e(this.settings.tpl.message).insertBefore(this.input);
      e(this.settings.tpl.errorLine).appendTo(i),
        this.isTouchDevice() === !0 && this.wrapper.addClass("touch-fallback"),
        this.input.attr("disabled") &&
          ((this.isDisabled = !0), this.wrapper.addClass("disabled")),
        this.settings.showLoader === !0 &&
          ((this.loader = e(this.settings.tpl.loader)),
          this.loader.insertBefore(this.input)),
        (this.preview = e(this.settings.tpl.preview)),
        this.preview.insertAfter(this.input),
        this.isDisabled === !1 &&
          this.settings.showRemove === !0 &&
          ((this.clearButton = e(this.settings.tpl.clearButton)),
          this.clearButton.insertAfter(this.input),
          this.clearButton.on("click", this.clearElement)),
        (this.filenameWrapper = e(this.settings.tpl.filename)),
        this.filenameWrapper.prependTo(
          this.preview.find(".dropify-infos-inner")
        ),
        this.settings.showErrors === !0 &&
          ((this.errorsContainer = e(this.settings.tpl.errorsContainer)),
          "outside" === this.settings.errorsPosition
            ? this.errorsContainer.insertAfter(this.wrapper)
            : this.errorsContainer.insertBefore(this.input));
      var t = this.settings.defaultFile || "";
      "" !== t.trim() &&
        ((this.file.name = this.cleanFilename(t)),
        this.setPreview(this.isImage(), t));
    }),
    (i.prototype.readFile = function (i) {
      if (i.files && i.files[0]) {
        var t = new FileReader(),
          s = new Image(),
          r = i.files[0],
          n = null,
          o = this,
          h = e.Event("dropify.fileReady");
        this.clearErrors(),
          this.showLoader(),
          this.setFileInformations(r),
          (this.errorsEvent.errors = []),
          this.checkFileSize(),
          this.isFileExtensionAllowed(),
          this.isImage() &&
          this.file.size < this.sizeToByte(this.settings.maxFileSizePreview)
            ? (this.input.on("dropify.fileReady", this.onFileReady),
              t.readAsDataURL(r),
              (t.onload = function (e) {
                (n = e.target.result),
                  (s.src = e.target.result),
                  (s.onload = function () {
                    o.setFileDimensions(this.width, this.height),
                      o.validateImage(),
                      o.input.trigger(h, [!0, n]);
                  });
              }.bind(this)))
            : this.onFileReady(!1);
      }
    }),
    (i.prototype.onFileReady = function (e, i, t) {
      if (
        (this.input.off("dropify.fileReady", this.onFileReady),
        0 === this.errorsEvent.errors.length)
      )
        this.setPreview(i, t);
      else {
        this.input.trigger(this.errorsEvent, [this]);
        for (var s = this.errorsEvent.errors.length - 1; s >= 0; s--) {
          var r = this.errorsEvent.errors[s].namespace,
            n = r.split(".").pop();
          this.showError(n);
        }
        if ("undefined" != typeof this.errorsContainer) {
          this.errorsContainer.addClass("visible");
          var o = this.errorsContainer;
          setTimeout(function () {
            o.removeClass("visible");
          }, this.settings.errorTimeout);
        }
        this.wrapper.addClass("has-error"),
          this.resetPreview(),
          this.clearElement();
      }
    }),
    (i.prototype.setFileInformations = function (e) {
      (this.file.object = e),
        (this.file.name = e.name),
        (this.file.size = e.size),
        (this.file.type = e.type),
        (this.file.width = null),
        (this.file.height = null);
    }),
    (i.prototype.setFileDimensions = function (e, i) {
      (this.file.width = e), (this.file.height = i);
    }),
    (i.prototype.setPreview = function (i, t) {
      this.wrapper.removeClass("has-error").addClass("has-preview"),
        this.filenameWrapper
          .children(".dropify-filename-inner")
          .html(this.file.name);
      var s = this.preview.children(".dropify-render");
      if ((this.hideLoader(), i === !0)) {
        var r = e("<img />").attr("src", t);
        this.settings.height && r.css("max-height", this.settings.height),
          r.appendTo(s);
      } else
        e("<i />").attr("class", "dropify-font-file").appendTo(s),
          e('<span class="dropify-extension" />')
            .html(this.getFileType())
            .appendTo(s);
      this.preview.fadeIn();
    }),
    (i.prototype.resetPreview = function () {
      this.wrapper.removeClass("has-preview");
      var e = this.preview.children(".dropify-render");
      e.find(".dropify-extension").remove(),
        e.find("i").remove(),
        e.find("img").remove(),
        this.preview.hide(),
        this.hideLoader();
    }),
    (i.prototype.cleanFilename = function (e) {
      var i = e.split("\\").pop();
      return i == e && (i = e.split("/").pop()), "" !== e ? i : "";
    }),
    (i.prototype.clearElement = function () {
      if (0 === this.errorsEvent.errors.length) {
        var i = e.Event("dropify.beforeClear");
        this.input.trigger(i, [this]),
          i.result !== !1 &&
            (this.resetFile(),
            this.input.val(""),
            this.resetPreview(),
            this.input.trigger(e.Event("dropify.afterClear"), [this]));
      } else this.resetFile(), this.input.val(""), this.resetPreview();
    }),
    (i.prototype.resetFile = function () {
      (this.file.object = null),
        (this.file.name = null),
        (this.file.size = null),
        (this.file.type = null),
        (this.file.width = null),
        (this.file.height = null);
    }),
    (i.prototype.setContainerSize = function () {
      this.settings.height && this.wrapper.height(this.settings.height);
    }),
    (i.prototype.isTouchDevice = function () {
      return (
        "ontouchstart" in window ||
        navigator.MaxTouchPoints > 0 ||
        navigator.msMaxTouchPoints > 0
      );
    }),
    (i.prototype.getFileType = function () {
      return this.file.name.split(".").pop().toLowerCase();
    }),
    (i.prototype.isImage = function () {
      return "-1" != this.settings.imgFileExtensions.indexOf(this.getFileType())
        ? !0
        : !1;
    }),
    (i.prototype.isFileExtensionAllowed = function () {
      return "-1" != this.settings.allowedFileExtensions.indexOf("*") ||
        "-1" != this.settings.allowedFileExtensions.indexOf(this.getFileType())
        ? !0
        : (this.pushError("fileExtension"), !1);
    }),
    (i.prototype.translateMessages = function () {
      for (var e in this.settings.tpl)
        for (var i in this.settings.messages)
          this.settings.tpl[e] = this.settings.tpl[e].replace(
            "{{ " + i + " }}",
            this.settings.messages[i]
          );
    }),
    (i.prototype.checkFileSize = function () {
      0 !== this.sizeToByte(this.settings.maxFileSize) &&
        this.file.size > this.sizeToByte(this.settings.maxFileSize) &&
        this.pushError("fileSize");
    }),
    (i.prototype.sizeToByte = function (e) {
      var i = 0;
      if (0 !== e) {
        var t = e.slice(-1).toUpperCase(),
          s = 1024,
          r = 1024 * s,
          n = 1024 * r;
        "K" === t
          ? (i = parseFloat(e) * s)
          : "M" === t
          ? (i = parseFloat(e) * r)
          : "G" === t && (i = parseFloat(e) * n);
      }
      return i;
    }),
    (i.prototype.validateImage = function () {
      0 !== this.settings.minWidth &&
        this.settings.minWidth >= this.file.width &&
        this.pushError("minWidth"),
        0 !== this.settings.maxWidth &&
          this.settings.maxWidth <= this.file.width &&
          this.pushError("maxWidth"),
        0 !== this.settings.minHeight &&
          this.settings.minHeight >= this.file.height &&
          this.pushError("minHeight"),
        0 !== this.settings.maxHeight &&
          this.settings.maxHeight <= this.file.height &&
          this.pushError("maxHeight"),
        "-1" == this.settings.allowedFormats.indexOf(this.getImageFormat()) &&
          this.pushError("imageFormat");
    }),
    (i.prototype.getImageFormat = function () {
      return this.file.width == this.file.height
        ? "square"
        : this.file.width < this.file.height
        ? "portrait"
        : this.file.width > this.file.height
        ? "landscape"
        : void 0;
    }),
    (i.prototype.pushError = function (i) {
      var t = e.Event("dropify.error." + i);
      this.errorsEvent.errors.push(t), this.input.trigger(t, [this]);
    }),
    (i.prototype.clearErrors = function () {
      "undefined" != typeof this.errorsContainer &&
        this.errorsContainer.children("ul").html("");
    }),
    (i.prototype.showError = function (e) {
      "undefined" != typeof this.errorsContainer &&
        this.errorsContainer
          .children("ul")
          .append("<li>" + this.getError(e) + "</li>");
    }),
    (i.prototype.getError = function (e) {
      var i = this.settings.error[e],
        t = "";
      return (
        "fileSize" === e
          ? (t = this.settings.maxFileSize)
          : "minWidth" === e
          ? (t = this.settings.minWidth)
          : "maxWidth" === e
          ? (t = this.settings.maxWidth)
          : "minHeight" === e
          ? (t = this.settings.minHeight)
          : "maxHeight" === e
          ? (t = this.settings.maxHeight)
          : "imageFormat" === e
          ? (t = this.settings.allowedFormats.join(", "))
          : "fileExtension" === e &&
            (t = this.settings.allowedFileExtensions.join(", ")),
        "" !== t ? i.replace("{{ value }}", t) : i
      );
    }),
    (i.prototype.showLoader = function () {
      "undefined" != typeof this.loader && this.loader.show();
    }),
    (i.prototype.hideLoader = function () {
      "undefined" != typeof this.loader && this.loader.hide();
    }),
    (i.prototype.destroy = function () {
      this.input.siblings().remove(), this.input.unwrap(), (this.isInit = !1);
    }),
    (i.prototype.init = function () {
      this.createElements();
    }),
    (i.prototype.isDropified = function () {
      return this.isInit;
    }),
    (e.fn[t] = function (s) {
      return (
        this.each(function () {
          e.data(this, t) || e.data(this, t, new i(this, s));
        }),
        this
      );
    }),
    i
  );
});
