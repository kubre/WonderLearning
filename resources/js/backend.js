import { createApp } from 'vue'
import SyllabusApp from './components/SyllabusApp';
import ChatScreen from './components/ChatScreen';

createApp(SyllabusApp).mount('#syllabusApp')
createApp(ChatScreen).mount('#chatScreen')