<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Messages Inbox') }}
            </h2>
            <p class="text-sm text-gray-500">Real-time candidate and recruiter chat communication</p>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 dark:bg-gray-900 min-h-screen"
         x-data="{
            searchQuery: '',
            activeChannelId: null,
            isTyping: false,
            messageText: '',
            attachmentName: '',
            uploadProgress: 0,
            isUploading: false,
            
            // Candidate messaging list database simulator
            channels: [
                {
                    id: 1,
                    name: 'Muhammad Maaz',
                    role: 'Senior Full-Stack Architect',
                    initials: 'MM',
                    online: true,
                    unreadCount: 0,
                    messages: [
                        { sender: 'candidate', text: 'Hello, I submitted my application for the Senior Architect role. Looking forward to discussing details!', time: '10:05 AM' },
                        { sender: 'employer', text: 'Hi Maaz! We reviewed your profile and projects. They look exceptionally clean.', time: '10:15 AM' },
                        { sender: 'candidate', text: 'Thank you. I am available for a video call anytime next week.', time: '10:20 AM' }
                    ]
                },
                {
                    id: 2,
                    name: 'Jane Doe',
                    role: 'Lead UX Designer',
                    initials: 'JD',
                    online: true,
                    unreadCount: 2,
                    messages: [
                        { sender: 'employer', text: 'Hi Jane, can you share a link to your Figma portfolio?', time: 'Yesterday' },
                        { sender: 'candidate', text: 'Sure! Here it is: figma.com/jane-design-portfolio', time: 'Yesterday' },
                        { sender: 'candidate', text: 'Also, I attached my latest resume PDF.', time: 'Yesterday' }
                    ]
                },
                {
                    id: 3,
                    name: 'John Smith',
                    role: 'DevOps Engineer',
                    initials: 'JS',
                    online: false,
                    unreadCount: 0,
                    messages: [
                        { sender: 'candidate', text: 'Hi recruiter, I am wondering if the DevOps position offers remote options?', time: '3 days ago' },
                        { sender: 'employer', text: 'Yes John, it is a fully remote position anywhere in Canada.', time: '3 days ago' }
                    ]
                }
            ],

            get activeChannel() {
                return this.channels.find(c => c.id === this.activeChannelId) || { name: '', role: '', online: false, messages: [] };
            },

            filteredChannels() {
                return this.channels.filter(c => c.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
            },

            sendMsg() {
                if (this.messageText.trim() || this.attachmentName) {
                    const text = this.messageText.trim();
                    const currentChannel = this.activeChannel;
                    
                    // Push message
                    currentChannel.messages.push({
                        sender: 'employer',
                        text: text || '📎 Attached file: ' + this.attachmentName,
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                    });
                    
                    this.messageText = '';
                    this.attachmentName = '';
                    
                    // Trigger simulated typing & response
                    this.isTyping = true;
                    setTimeout(() => {
                        this.isTyping = false;
                        currentChannel.messages.push({
                            sender: 'candidate',
                            text: 'Thanks! I received that. I will get back to you shortly.',
                            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                        });
                    }, 2000);
                }
            },

            triggerAttachment(e) {
                const file = e.target.files[0];
                if (file) {
                    this.attachmentName = file.name;
                    this.isUploading = true;
                    this.uploadProgress = 0;
                    
                    // Simulate upload progress
                    const interval = setInterval(() => {
                        if (this.uploadProgress < 100) {
                            this.uploadProgress += 20;
                        } else {
                            clearInterval(interval);
                            this.isUploading = false;
                            this.sendMsg();
                        }
                    }, 150);
                }
            }
         }"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-150 dark:border-gray-700/50 shadow-sm h-[600px] flex overflow-hidden">
                
                <!-- Chat List Pane (Left Column) -->
                <div class="w-full md:w-1/3 border-r border-gray-150 dark:border-gray-700 flex flex-col bg-white dark:bg-gray-800">
                    <!-- Search Input -->
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="relative">
                            <input type="text" x-model="searchQuery" placeholder="Search conversations..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-dark-850 text-xs font-semibold focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">🔍</span>
                        </div>
                    </div>

                    <!-- Scrollable Channels list -->
                    <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-750">
                        <template x-for="channel in filteredChannels()" :key="channel.id">
                            <button @click="activeChannelId = channel.id; channel.unreadCount = 0" 
                                    :class="activeChannelId === channel.id ? 'bg-primary-50/50 dark:bg-dark-850 text-primary-500 border-l-4 border-primary-500' : 'hover:bg-gray-50 dark:hover:bg-dark-800/40'" 
                                    class="w-full text-left p-4 flex items-center justify-between cursor-pointer transition">
                                <div class="flex items-center gap-3">
                                    <!-- Initial Icon / Avatar -->
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xs relative"
                                         :class="channel.id % 2 === 0 ? 'bg-purple-100 text-purple-600' : 'bg-primary-100 text-primary-600'">
                                        <span x-text="channel.initials"></span>
                                        <!-- Online Status indicator badge -->
                                        <span x-show="channel.online" class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white truncate" x-text="channel.name"></h4>
                                        <p class="text-[10px] text-gray-400 truncate" x-text="channel.role"></p>
                                    </div>
                                </div>
                                
                                <!-- Unread counts badge -->
                                <span x-show="channel.unreadCount > 0" class="px-2 py-0.5 bg-red-500 text-white text-[9px] font-black rounded-full" x-text="channel.unreadCount"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Chat Dialog Pane (Right Column) -->
                <div class="hidden md:flex md:w-2/3 flex-col justify-between h-full bg-gray-50/50 dark:bg-dark-900/10 relative">
                    
                    <!-- Empty State View -->
                    <div x-show="activeChannelId === null" class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 space-y-4" x-transition>
                        <div class="w-16 h-16 rounded-3xl bg-primary-50 dark:bg-dark-850 text-primary-500 flex items-center justify-center text-2xl shadow-sm border border-gray-100 dark:border-gray-700/50">
                            💬
                        </div>
                        <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Start a Conversation</h3>
                        <p class="text-xs text-gray-500 max-w-xs leading-relaxed">Select a candidate or recruiter thread from the list on the left to start message communication.</p>
                    </div>

                    <!-- Active Chat Details -->
                    <div x-show="activeChannelId !== null" class="flex flex-col justify-between h-full w-full" x-transition style="display: none;">
                        <!-- Top Info Header -->
                        <div class="px-6 py-4 border-b border-gray-150 dark:border-gray-700 bg-white dark:bg-gray-800 flex justify-between items-center shrink-0">
                            <div>
                                <h3 class="font-extrabold text-base text-gray-900 dark:text-white" x-text="activeChannel.name"></h3>
                                <p class="text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                    <span :class="activeChannel.online ? 'bg-emerald-500' : 'bg-gray-400'" class="w-1.5 h-1.5 rounded-full"></span>
                                    <span x-text="activeChannel.online ? 'Active Now' : 'Offline'"></span>
                                    <span>&bull;</span>
                                    <span x-text="activeChannel.role"></span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" class="p-2 hover:bg-gray-100 dark:hover:bg-dark-800 rounded-lg text-gray-400 text-xs">📞 Call</button>
                                <button type="button" class="p-2 hover:bg-gray-100 dark:hover:bg-dark-800 rounded-lg text-gray-400 text-xs">📝 Profile</button>
                            </div>
                        </div>

                        <!-- Scrollable Bubble conversation list -->
                        <div class="flex-1 p-6 overflow-y-auto space-y-4">
                            <template x-for="(msg, i) in activeChannel.messages" :key="i">
                                <div class="flex" :class="msg.sender === 'employer' ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-[70%] space-y-1">
                                        <div class="p-3.5 rounded-2xl text-xs leading-relaxed"
                                             :class="msg.sender === 'employer' ? 'bg-primary-500 text-white rounded-tr-none shadow-sm' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 rounded-tl-none border border-gray-150 dark:border-gray-700'">
                                            <p x-text="msg.text"></p>
                                        </div>
                                        <span class="text-[9px] text-gray-400 block px-1" :class="msg.sender === 'employer' ? 'text-right' : 'text-left'" x-text="msg.time"></span>
                                    </div>
                                </div>
                            </template>

                            <!-- Typing Animation dots indicator -->
                            <div x-show="isTyping" class="flex justify-start items-center gap-2" x-transition>
                                <div class="bg-white dark:bg-gray-800 border border-gray-150 dark:border-gray-700 px-4 py-2.5 rounded-2xl rounded-tl-none flex items-center gap-1 text-xs">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-75"></span>
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-150"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress bar for upload simulator -->
                        <div x-show="isUploading" class="px-6 py-2 bg-gray-100 dark:bg-dark-850 flex items-center justify-between text-xs text-gray-500 border-t border-gray-150">
                            <span class="truncate" x-text="'Uploading: ' + attachmentName"></span>
                            <div class="w-1/3 bg-gray-200 dark:bg-dark-800 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-primary-500 h-full transition-all duration-150" :style="'width: ' + uploadProgress + '%'"></div>
                            </div>
                        </div>

                        <!-- Bottom message text panel inputs -->
                        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-150 dark:border-gray-700/50 flex items-center gap-2 shrink-0">
                            <!-- Attachment mock inputs -->
                            <label class="p-2 hover:bg-gray-100 dark:hover:bg-dark-800 rounded-xl cursor-pointer text-gray-400 shrink-0 text-sm flex items-center justify-center" title="Attach file">
                                📎
                                <input type="file" @change="triggerAttachment($event)" class="hidden" />
                            </label>
                            
                            <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type your message..." class="flex-1 px-4 py-2.5 rounded-xl border border-gray-250 dark:border-gray-700 bg-gray-50 dark:bg-dark-850 text-gray-900 dark:text-gray-100 text-xs font-semibold focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                            
                            <button type="button" @click="sendMsg()" class="px-5 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-xs font-extrabold shadow-sm transition cursor-pointer">
                                Send Message
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
