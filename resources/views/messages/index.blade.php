<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Messages Inbox') }}
            </h2>
            <p>Real-time candidate and recruiter chat communication</p>
        </div>
    </x-slot>

    <div
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
        <div>
            <div>
                
                <!-- Chat List Pane (Left Column) -->
                <div>
                    <!-- Search Input -->
                    <div>
                        <div>
                            <input type="text" x-model="searchQuery" placeholder="Search conversations...">
                            <span>🔍</span>
                        </div>
                    </div>

                    <!-- Scrollable Channels list -->
                    <div>
                        <template x-for="channel in filteredChannels()" :key="channel.id">
                            <button @click="activeChannelId = channel.id; channel.unreadCount = 0" 
                                    :>
                                <div>
                                    <!-- Initial Icon / Avatar -->
                                    <div
                                         :>
                                        <span x-text="channel.initials"></span>
                                        <!-- Online Status indicator badge -->
                                        <span x-show="channel.online"></span>
                                    </div>
                                    <div>
                                        <h4 x-text="channel.name"></h4>
                                        <p x-text="channel.role"></p>
                                    </div>
                                </div>
                                
                                <!-- Unread counts badge -->
                                <span x-show="channel.unreadCount > 0" x-text="channel.unreadCount"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Chat Dialog Pane (Right Column) -->
                <div>
                    
                    <!-- Empty State View -->
                    <div x-show="activeChannelId === null" x-transition>
                        <div>
                            💬
                        </div>
                        <h3>Start a Conversation</h3>
                        <p>Select a candidate or recruiter thread from the list on the left to start message communication.</p>
                    </div>

                    <!-- Active Chat Details -->
                    <div x-show="activeChannelId !== null" x-transition>
                        <!-- Top Info Header -->
                        <div>
                            <div>
                                <h3 x-text="activeChannel.name"></h3>
                                <p>
                                    <span :></span>
                                    <span x-text="activeChannel.online ? 'Active Now' : 'Offline'"></span>
                                    <span>&bull;</span>
                                    <span x-text="activeChannel.role"></span>
                                </p>
                            </div>
                            <div>
                                <button type="button">📞 Call</button>
                                <button type="button">📝 Profile</button>
                            </div>
                        </div>

                        <!-- Scrollable Bubble conversation list -->
                        <div>
                            <template x-for="(msg, i) in activeChannel.messages" :key="i">
                                <div :>
                                    <div>
                                        <div
                                             :>
                                            <p x-text="msg.text"></p>
                                        </div>
                                        <span : x-text="msg.time"></span>
                                    </div>
                                </div>
                            </template>

                            <!-- Typing Animation dots indicator -->
                            <div x-show="isTyping" x-transition>
                                <div>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Progress bar for upload simulator -->
                        <div x-show="isUploading">
                            <span x-text="'Uploading: ' + attachmentName"></span>
                            <div>
                                <div :></div>
                            </div>
                        </div>

                        <!-- Bottom message text panel inputs -->
                        <div>
                            <!-- Attachment mock inputs -->
                            <label title="Attach file">
                                📎
                                <input type="file" @change="triggerAttachment($event)" />
                            </label>
                            
                            <input type="text" x-model="messageText" @keydown.enter.prevent="sendMsg()" placeholder="Type your message...">
                            
                            <button type="button" @click="sendMsg()">
                                Send Message
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
