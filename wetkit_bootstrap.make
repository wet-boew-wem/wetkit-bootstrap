; WetKit Bootstrap Makefile

core = 7.x
api = 2

; Theme(s)

projects[bootstrap][version] = 3.10
projects[bootstrap][type] = theme
projects[bootstrap][patch][2311463] = http://drupal.org/files/issues/patch_bootstrap_wetkit-2311463-05.patch
projects[bootstrap][patch][2469635] = http://drupal.org/files/issues/bootstrap-no_responsive_on_multi_val_form_elements-2469635-1.patch
projects[bootstrap][patch][2556733] = http://drupal.org/files/issues/update_to_bootstrap-2556733-14.patch
