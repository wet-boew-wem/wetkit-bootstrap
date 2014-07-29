; WetKit Bootstrap Makefile

core = 7.x
api = 2

; Theme(s)

projects[bootstrap][version] = 1.x-dev
projects[bootstrap][type] = theme
projects[bootstrap][download][type] = git
projects[bootstrap][download][revision] = fde7a1d
projects[bootstrap][download][branch] = 7.x-1.x
projects[bootstrap][patch][2311463] = http://drupal.org/files/issues/patch_bootstrap_wetkit-2311463-01.patch
