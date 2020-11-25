import Vue from 'vue'
import dayjs from 'dayjs'

Vue.filter('dateDiffForHumans', value => dayjs(value))
Vue.filter('', value => dayjs(value))
