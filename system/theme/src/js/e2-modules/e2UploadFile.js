function e2UploadFile (file, url, progressCallback, doneCallback, errorCallback) {
  if (window.FormData) {
    const data = new window.FormData()
    data.append('file', file)

    $.ajax({
      type: 'POST',
      timeout: 0,
      url: url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {
        const myXhr = $.ajaxSettings.xhr()
        if (myXhr.upload) {
          myXhr.upload.addEventListener('progress', progressCallback, false)
        }
        return myXhr
      },
      success: doneCallback,
      error: errorCallback
    })
  }
}

export default e2UploadFile
