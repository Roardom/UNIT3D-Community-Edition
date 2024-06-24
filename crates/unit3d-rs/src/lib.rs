use std::ffi::{c_char, CStr, CString};

use comrak::{markdown_to_html, ComrakOptions};

#[no_mangle]
pub extern "C" fn page(content: *const c_char) -> *const c_char {
    let markdown = unsafe { CStr::from_ptr(content) }.to_str().unwrap();

    let html = markdown_to_html(markdown, &ComrakOptions::default());

    return CString::new(html).unwrap().into_raw();
}
