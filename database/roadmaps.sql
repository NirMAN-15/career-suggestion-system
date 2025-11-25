-- INSERT ROADMAPS FOR ALL 15 IT CAREERS
-- Run this in phpMyAdmin to populate roadmap_steps table

USE career_suggestion_db;

-- Clear existing roadmap steps (optional - uncomment if needed)
-- TRUNCATE TABLE user_roadmap_progress;
-- TRUNCATE TABLE roadmap_steps;

-- ===================================
-- 1. SOFTWARE DEVELOPER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(1, 1, 'Learn Programming Fundamentals', 'Master the basics of programming including variables, data types, control structures, and functions. Start with a beginner-friendly language like Python or JavaScript.', '2-3 months'),
(1, 2, 'Study Data Structures & Algorithms', 'Learn essential data structures (arrays, linked lists, trees, graphs) and algorithms (sorting, searching, dynamic programming).', '3-4 months'),
(1, 3, 'Build Your First Projects', 'Create 3-5 personal projects to apply your knowledge. Build a portfolio website, a to-do app, and a simple game.', '2-3 months'),
(1, 4, 'Learn Version Control (Git)', 'Master Git and GitHub for version control. Learn branching, merging, pull requests, and collaboration workflows.', '2-4 weeks'),
(1, 5, 'Master a Programming Language', 'Become proficient in at least one language (Java, Python, C++, or JavaScript). Understand OOP concepts and best practices.', '3-4 months'),
(1, 6, 'Learn Database Management', 'Study SQL and database design. Learn to work with MySQL, PostgreSQL, or MongoDB.', '1-2 months'),
(1, 7, 'Build a Full Application', 'Create a complete application demonstrating end-to-end development skills. This will be your portfolio centerpiece.', '2-3 months'),
(1, 8, 'Prepare for Interviews', 'Practice coding problems on LeetCode and HackerRank. Do mock interviews and study common questions.', '2-3 months'),
(1, 9, 'Apply for Positions', 'Start applying for junior developer positions. Tailor your resume and build your professional network.', '2-4 months');

-- ===================================
-- 2. WEB DEVELOPER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(2, 1, 'Master HTML & CSS', 'Learn HTML5 semantic elements, CSS3 styling, flexbox, and grid. Build responsive layouts.', '1-2 months'),
(2, 2, 'Learn JavaScript Fundamentals', 'Master JavaScript basics including DOM manipulation, events, async programming, and ES6+ features.', '2-3 months'),
(2, 3, 'Study Responsive Web Design', 'Learn mobile-first design, media queries, and frameworks like Bootstrap or Tailwind CSS.', '1-2 months'),
(2, 4, 'Master a Frontend Framework', 'Choose and learn React, Vue, or Angular. Build single-page applications with modern tools.', '3-4 months'),
(2, 5, 'Learn Backend Basics', 'Study Node.js, Express, or another backend technology. Understand server-side programming.', '2-3 months'),
(2, 6, 'Study APIs & HTTP', 'Learn RESTful APIs, fetch data, handle authentication, and work with third-party APIs.', '1-2 months'),
(2, 7, 'Learn Database Integration', 'Connect your applications to databases. Learn SQL and NoSQL database operations.', '1-2 months'),
(2, 8, 'Build Portfolio Projects', 'Create 5+ web projects showcasing different skills. Include responsive sites and full-stack apps.', '3-4 months'),
(2, 9, 'Learn Deployment', 'Deploy your projects using platforms like Netlify, Vercel, or Heroku. Learn basic DevOps.', '2-4 weeks'),
(2, 10, 'Apply for Web Dev Positions', 'Create a strong portfolio, update your resume, and start applying for web developer roles.', '2-3 months');

-- ===================================
-- 3. UI/UX DESIGNER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(3, 1, 'Learn Design Principles', 'Study color theory, typography, layout, hierarchy, and composition. Understand basic design fundamentals.', '1-2 months'),
(3, 2, 'Master Design Tools', 'Learn Figma, Adobe XD, or Sketch. Practice creating mockups, wireframes, and prototypes.', '2-3 months'),
(3, 3, 'Study User Research', 'Learn how to conduct user interviews, surveys, and usability testing. Understand user psychology.', '1-2 months'),
(3, 4, 'Learn Wireframing', 'Create low-fidelity and high-fidelity wireframes. Map user flows and information architecture.', '1-2 months'),
(3, 5, 'Master Prototyping', 'Build interactive prototypes using Figma or Adobe XD. Learn micro-interactions and animations.', '1-2 months'),
(3, 6, 'Study Accessibility', 'Learn WCAG guidelines and inclusive design principles. Design for all users including those with disabilities.', '1 month'),
(3, 7, 'Learn Responsive Design', 'Design for multiple screen sizes. Understand mobile-first approach and adaptive layouts.', '1-2 months'),
(3, 8, 'Build Design Portfolio', 'Create 5+ case studies showing your design process from research to final design.', '2-3 months'),
(3, 9, 'Learn Basic Frontend Code', 'Understand HTML, CSS basics to better collaborate with developers. Learn design systems.', '1-2 months'),
(3, 10, 'Network & Apply', 'Build your online presence, join design communities, and apply for UI/UX designer positions.', '2-3 months');

-- ===================================
-- 4. QA TESTER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(4, 1, 'Learn QA Fundamentals', 'Understand software testing lifecycle, types of testing, and quality assurance principles.', '1-2 months'),
(4, 2, 'Study Testing Methodologies', 'Learn manual testing, black box, white box, regression, and integration testing techniques.', '1-2 months'),
(4, 3, 'Learn Test Case Writing', 'Practice writing detailed test cases, test plans, and test scenarios for different applications.', '1 month'),
(4, 4, 'Master Bug Tracking Tools', 'Learn Jira, Bugzilla, or similar tools. Practice reporting and tracking defects effectively.', '2-4 weeks'),
(4, 5, 'Learn SQL for Testing', 'Study database queries to validate backend data. Learn to write SQL tests for data integrity.', '1-2 months'),
(4, 6, 'Study Automation Testing', 'Learn Selenium, Cypress, or Playwright for automated testing. Write automated test scripts.', '2-3 months'),
(4, 7, 'Learn API Testing', 'Master Postman or REST Assured for testing APIs. Understand API documentation and endpoints.', '1-2 months'),
(4, 8, 'Study Performance Testing', 'Learn JMeter or LoadRunner for load and stress testing. Understand performance metrics.', '1-2 months'),
(4, 9, 'Get QA Certifications', 'Pursue ISTQB Foundation Level or similar certifications to validate your testing knowledge.', '2-3 months'),
(4, 10, 'Apply for QA Positions', 'Build a portfolio of test cases and automation scripts. Apply for QA tester roles.', '2-3 months');

-- ===================================
-- 5. MOBILE APP DEVELOPER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(5, 1, 'Choose Your Platform', 'Decide between iOS (Swift), Android (Kotlin), or cross-platform (React Native/Flutter).', '1 week'),
(5, 2, 'Learn Programming Language', 'Master Swift for iOS, Kotlin for Android, or JavaScript/Dart for cross-platform development.', '2-3 months'),
(5, 3, 'Study Mobile UI/UX', 'Learn mobile design patterns, navigation, and platform-specific guidelines (Material Design, Human Interface).', '1-2 months'),
(5, 4, 'Master Development Tools', 'Learn Xcode for iOS, Android Studio for Android, or VS Code for cross-platform development.', '1 month'),
(5, 5, 'Build Simple Apps', 'Create basic apps like calculator, to-do list, and weather app to practice fundamentals.', '2-3 months'),
(5, 6, 'Learn Data Persistence', 'Study local storage, SQLite, Realm, or cloud databases for storing app data.', '1-2 months'),
(5, 7, 'Study APIs & Networking', 'Learn to integrate REST APIs, handle JSON data, and implement network requests in apps.', '1-2 months'),
(5, 8, 'Build Portfolio Apps', 'Create 3-5 complete apps demonstrating various features. Publish at least one to app stores.', '3-4 months'),
(5, 9, 'Learn App Deployment', 'Master the app store submission process for Google Play or Apple App Store.', '2-4 weeks'),
(5, 10, 'Apply for Mobile Dev Jobs', 'Showcase your published apps, create a developer portfolio, and apply for positions.', '2-3 months');

-- ===================================
-- 6. CLOUD ENGINEER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(6, 1, 'Learn Cloud Fundamentals', 'Understand cloud computing concepts, service models (IaaS, PaaS, SaaS), and deployment models.', '1-2 months'),
(6, 2, 'Choose a Cloud Platform', 'Focus on AWS, Azure, or Google Cloud. Start with one and master its core services.', '1 week'),
(6, 3, 'Study Core Services', 'Learn compute (EC2, VMs), storage (S3, Blob), networking (VPC), and database services.', '2-3 months'),
(6, 4, 'Learn Linux & Networking', 'Master Linux command line, shell scripting, and networking fundamentals (TCP/IP, DNS, load balancing).', '2-3 months'),
(6, 5, 'Study Infrastructure as Code', 'Learn Terraform or CloudFormation to automate infrastructure deployment and management.', '1-2 months'),
(6, 6, 'Master Containers', 'Learn Docker for containerization and Kubernetes for container orchestration.', '2-3 months'),
(6, 7, 'Learn CI/CD Pipelines', 'Study continuous integration and deployment using Jenkins, GitLab CI, or GitHub Actions.', '1-2 months'),
(6, 8, 'Study Cloud Security', 'Learn IAM, encryption, security groups, and cloud security best practices.', '1-2 months'),
(6, 9, 'Get Cloud Certifications', 'Pursue AWS Solutions Architect, Azure Administrator, or Google Cloud Engineer certification.', '2-3 months'),
(6, 10, 'Build Cloud Projects', 'Deploy real applications to the cloud, implement auto-scaling, monitoring, and disaster recovery.', '2-3 months'),
(6, 11, 'Apply for Cloud Positions', 'Showcase your certifications and cloud projects. Apply for cloud engineer roles.', '2-3 months');

-- ===================================
-- 7. DEVOPS ENGINEER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(7, 1, 'Learn Linux Administration', 'Master Linux commands, file systems, processes, and shell scripting (Bash).', '2-3 months'),
(7, 2, 'Study Version Control', 'Master Git, GitHub/GitLab workflows, branching strategies, and collaboration practices.', '1 month'),
(7, 3, 'Learn Networking Basics', 'Understand TCP/IP, DNS, HTTP/HTTPS, firewalls, and load balancing concepts.', '1-2 months'),
(7, 4, 'Master CI/CD Tools', 'Learn Jenkins, GitLab CI, GitHub Actions, or CircleCI for automated build and deployment.', '2-3 months'),
(7, 5, 'Study Containerization', 'Master Docker for creating, managing, and deploying containers. Learn Docker Compose.', '1-2 months'),
(7, 6, 'Learn Kubernetes', 'Study container orchestration, pods, services, deployments, and Kubernetes architecture.', '2-3 months'),
(7, 7, 'Master Infrastructure as Code', 'Learn Terraform or Ansible for automating infrastructure provisioning and configuration.', '2-3 months'),
(7, 8, 'Study Cloud Platforms', 'Get familiar with AWS, Azure, or GCP. Learn cloud-native DevOps services.', '2-3 months'),
(7, 9, 'Learn Monitoring Tools', 'Master Prometheus, Grafana, ELK Stack for monitoring, logging, and observability.', '1-2 months'),
(7, 10, 'Build DevOps Projects', 'Create CI/CD pipelines, deploy applications to Kubernetes, implement monitoring solutions.', '2-3 months'),
(7, 11, 'Apply for DevOps Roles', 'Showcase your automation projects and DevOps skills. Apply for DevOps engineer positions.', '2-3 months');

-- ===================================
-- 8. CYBERSECURITY ANALYST ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(8, 1, 'Learn Security Fundamentals', 'Understand CIA triad, security principles, threat landscape, and common vulnerabilities.', '1-2 months'),
(8, 2, 'Study Networking', 'Master TCP/IP, protocols, firewalls, VPNs, and network security architecture.', '2-3 months'),
(8, 3, 'Learn Operating Systems', 'Study Windows and Linux security, hardening techniques, and system administration.', '2-3 months'),
(8, 4, 'Study Cryptography', 'Learn encryption algorithms, hashing, digital signatures, PKI, and secure communications.', '1-2 months'),
(8, 5, 'Master Security Tools', 'Learn Wireshark, Nmap, Metasploit, Burp Suite, and other security testing tools.', '2-3 months'),
(8, 6, 'Study Ethical Hacking', 'Learn penetration testing methodologies, vulnerability assessment, and exploitation techniques.', '2-3 months'),
(8, 7, 'Learn SIEM Tools', 'Master Security Information and Event Management tools like Splunk or QRadar.', '1-2 months'),
(8, 8, 'Study Compliance', 'Understand security frameworks (NIST, ISO 27001), regulations (GDPR, HIPAA), and compliance.', '1-2 months'),
(8, 9, 'Get Security Certifications', 'Pursue Security+, CEH, or CISSP certifications to validate your cybersecurity knowledge.', '3-6 months'),
(8, 10, 'Practice in Labs', 'Use platforms like Hack The Box, TryHackMe, or set up your own security lab.', '3-6 months'),
(8, 11, 'Apply for Security Jobs', 'Build a portfolio of security projects and certifications. Apply for cybersecurity analyst roles.', '2-3 months');

-- ===================================
-- 9. DATA ANALYST ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(9, 1, 'Master Excel', 'Learn advanced Excel functions, pivot tables, VLOOKUP, data cleaning, and analysis techniques.', '1-2 months'),
(9, 2, 'Learn SQL', 'Master database querying, joins, aggregations, subqueries, and window functions.', '2-3 months'),
(9, 3, 'Study Statistics', 'Learn descriptive statistics, probability, hypothesis testing, and statistical inference.', '2-3 months'),
(9, 4, 'Learn Python/R', 'Master Python (Pandas, NumPy) or R for data manipulation and statistical analysis.', '2-3 months'),
(9, 5, 'Master Data Visualization', 'Learn Tableau, Power BI, or Python libraries (Matplotlib, Seaborn) for creating compelling visualizations.', '1-2 months'),
(9, 6, 'Study Data Cleaning', 'Learn techniques for handling missing data, outliers, and preparing data for analysis.', '1 month'),
(9, 7, 'Learn Business Intelligence', 'Understand KPIs, metrics, dashboards, and how to translate business questions into analyses.', '1-2 months'),
(9, 8, 'Build Analysis Projects', 'Create 5+ data analysis projects covering different industries and business problems.', '2-3 months'),
(9, 9, 'Learn Storytelling', 'Master presenting insights to stakeholders, creating reports, and data-driven storytelling.', '1-2 months'),
(9, 10, 'Create Portfolio', 'Build a portfolio website showcasing your analysis projects and visualization skills.', '1 month'),
(9, 11, 'Apply for Analyst Roles', 'Network with data professionals and apply for data analyst positions.', '2-3 months');

-- ===================================
-- 10. AI/ML ENGINEER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(10, 1, 'Master Python Programming', 'Become proficient in Python including OOP, data structures, and algorithms.', '2-3 months'),
(10, 2, 'Study Mathematics', 'Learn linear algebra, calculus, probability, and statistics - essential for ML.', '3-4 months'),
(10, 3, 'Learn Data Science Libraries', 'Master NumPy, Pandas, Matplotlib, and Seaborn for data manipulation and visualization.', '2-3 months'),
(10, 4, 'Study Machine Learning', 'Learn supervised/unsupervised learning, regression, classification, clustering algorithms.', '3-4 months'),
(10, 5, 'Master Scikit-learn', 'Implement ML algorithms, model selection, hyperparameter tuning, and evaluation metrics.', '2-3 months'),
(10, 6, 'Learn Deep Learning', 'Study neural networks, backpropagation, CNNs, RNNs, and transformers.', '3-4 months'),
(10, 7, 'Master TensorFlow/PyTorch', 'Build and train deep learning models using popular frameworks.', '2-3 months'),
(10, 8, 'Study NLP/Computer Vision', 'Specialize in natural language processing or computer vision based on your interest.', '2-3 months'),
(10, 9, 'Practice on Real Projects', 'Participate in Kaggle competitions and build portfolio projects demonstrating ML skills.', '3-6 months'),
(10, 10, 'Learn MLOps', 'Study model deployment, monitoring, versioning, and production ML systems.', '2-3 months'),
(10, 11, 'Build ML Portfolio', 'Create comprehensive projects showing the full ML lifecycle from data to deployment.', '2-3 months'),
(10, 12, 'Apply for ML Positions', 'Network in the AI/ML community and apply for machine learning engineer roles.', '2-3 months');

-- ===================================
-- 11. IT SUPPORT TECHNICIAN ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(11, 1, 'Learn Computer Basics', 'Understand hardware components, operating systems, and basic troubleshooting.', '1-2 months'),
(11, 2, 'Master Windows/Mac OS', 'Learn system administration, user management, and common OS issues.', '1-2 months'),
(11, 3, 'Study Networking Basics', 'Learn TCP/IP, DNS, DHCP, routers, switches, and basic network troubleshooting.', '1-2 months'),
(11, 4, 'Learn Help Desk Software', 'Master ticketing systems like ServiceNow, Zendesk, or Jira Service Management.', '1 month'),
(11, 5, 'Study Active Directory', 'Learn user and group management, policies, and domain administration.', '1-2 months'),
(11, 6, 'Develop Soft Skills', 'Practice customer service, communication, patience, and problem-solving skills.', 'Ongoing'),
(11, 7, 'Get CompTIA A+ Certified', 'Study for and pass CompTIA A+ certification exam for hardware and software fundamentals.', '2-3 months'),
(11, 8, 'Learn Remote Support Tools', 'Master TeamViewer, Remote Desktop, and other remote assistance tools.', '2-4 weeks'),
(11, 9, 'Study Mobile Devices', 'Learn iOS and Android support, MDM systems, and mobile troubleshooting.', '1-2 months'),
(11, 10, 'Gain Practical Experience', 'Volunteer for IT support, do internships, or offer help desk services to gain experience.', '3-6 months'),
(11, 11, 'Apply for IT Support Jobs', 'Create a resume highlighting your certifications and customer service skills.', '2-3 months');

-- ===================================
-- 12. NETWORK ENGINEER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(12, 1, 'Learn Networking Fundamentals', 'Study OSI model, TCP/IP, subnetting, and basic networking concepts.', '2-3 months'),
(12, 2, 'Master Cisco Equipment', 'Learn Cisco routers, switches, and IOS command-line interface.', '2-3 months'),
(12, 3, 'Study Routing Protocols', 'Learn OSPF, EIGRP, BGP, and static routing configurations.', '2-3 months'),
(12, 4, 'Learn Switching', 'Master VLANs, STP, trunking, and switch security features.', '1-2 months'),
(12, 5, 'Study Network Security', 'Learn firewalls, VPNs, ACLs, and security best practices.', '2-3 months'),
(12, 6, 'Get CCNA Certified', 'Study for and pass Cisco CCNA certification exam.', '3-4 months'),
(12, 7, 'Learn Wireless Networking', 'Study WiFi standards, access points, controllers, and wireless security.', '1-2 months'),
(12, 8, 'Master Network Monitoring', 'Learn tools like PRTG, SolarWinds, Nagios for network monitoring and management.', '1-2 months'),
(12, 9, 'Study Network Design', 'Learn to design scalable, redundant, and efficient network architectures.', '2-3 months'),
(12, 10, 'Build Home Lab', 'Set up a home lab with routers, switches, or use GNS3/Packet Tracer for practice.', '2-4 months'),
(12, 11, 'Apply for Network Jobs', 'Showcase your CCNA and practical skills. Apply for network engineer positions.', '2-3 months');

-- ===================================
-- 13. BUSINESS ANALYST ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(13, 1, 'Learn BA Fundamentals', 'Understand the role of a business analyst, requirements gathering, and stakeholder management.', '1-2 months'),
(13, 2, 'Study Requirements Analysis', 'Learn to elicit, analyze, document, and validate business requirements.', '2-3 months'),
(13, 3, 'Master Process Modeling', 'Learn BPMN, flowcharts, and process mapping techniques using tools like Visio or Lucidchart.', '1-2 months'),
(13, 4, 'Learn SQL & Data Analysis', 'Master SQL for querying databases and analyzing business data.', '2-3 months'),
(13, 5, 'Study Agile & Scrum', 'Learn agile methodologies, user stories, sprints, and working in agile teams.', '1-2 months'),
(13, 6, 'Master Documentation', 'Learn to create BRDs, FRDs, use cases, and other business analysis documents.', '1-2 months'),
(13, 7, 'Learn Data Visualization', 'Use Excel, Tableau, or Power BI to create dashboards and present data insights.', '1-2 months'),
(13, 8, 'Develop Communication Skills', 'Practice presenting to stakeholders, facilitating meetings, and conflict resolution.', 'Ongoing'),
(13, 9, 'Get BA Certification', 'Consider CBAP, PMI-PBA, or similar business analyst certifications.', '3-4 months'),
(13, 10, 'Build Case Studies', 'Document 3-5 projects showing your requirements gathering and analysis process.', '2-3 months'),
(13, 11, 'Network & Apply', 'Join BA communities, attend meetups, and apply for business analyst roles.', '2-3 months');

-- ===================================
-- 14. PROJECT MANAGER ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(14, 1, 'Learn PM Fundamentals', 'Study project management basics, lifecycle, and the five process groups (PMBOK).', '1-2 months'),
(14, 2, 'Master Agile & Scrum', 'Learn agile principles, scrum framework, sprints, and agile project management.', '1-2 months'),
(14, 3, 'Study PM Tools', 'Master Jira, Asana, Trello, MS Project, or other project management software.', '1-2 months'),
(14, 4, 'Learn Scheduling', 'Understand Gantt charts, critical path method, and resource allocation.', '1-2 months'),
(14, 5, 'Study Risk Management', 'Learn to identify, assess, and mitigate project risks effectively.', '1-2 months'),
(14, 6, 'Master Budget Management', 'Learn cost estimation, budgeting, and financial tracking for projects.', '1-2 months'),
(14, 7, 'Develop Leadership Skills', 'Practice team management, motivation, conflict resolution, and stakeholder management.', 'Ongoing'),
(14, 8, 'Get PMP Certified', 'Study for and pass the PMP (Project Management Professional) certification.', '3-6 months'),
(14, 9, 'Lead Real Projects', 'Volunteer to manage projects at work or in community organizations for experience.', '6-12 months'),
(14, 10, 'Build PM Portfolio', 'Document successful projects showing your planning, execution, and results.', '2-3 months'),
(14, 11, 'Apply for PM Roles', 'Network with other PMs and apply for project manager positions.', '2-3 months');

-- ===================================
-- 15. DATABASE ADMINISTRATOR ROADMAP
-- ===================================
INSERT INTO roadmap_steps (career_id, step_order, step_title, step_description, estimated_duration) VALUES
(15, 1, 'Learn Database Fundamentals', 'Understand relational databases, normalization, ER diagrams, and database design.', '1-2 months'),
(15, 2, 'Master SQL', 'Learn advanced SQL including complex queries, stored procedures, triggers, and functions.', '2-3 months'),
(15, 3, 'Choose a Database Platform', 'Focus on Oracle, MySQL, PostgreSQL, or SQL Server and master its features.', '1 week'),
(15, 4, 'Study Database Installation', 'Learn to install, configure, and set up database servers properly.', '1-2 months'),
(15, 5, 'Learn Backup & Recovery', 'Master backup strategies, recovery procedures, and disaster recovery planning.', '1-2 months'),
(15, 6, 'Study Performance Tuning', 'Learn query optimization, indexing strategies, and database performance monitoring.', '2-3 months'),
(15, 7, 'Master Database Security', 'Study user management, encryption, auditing, and security best practices.', '1-2 months'),
(15, 8, 'Learn High Availability', 'Study replication, clustering, failover, and ensuring database uptime.', '2-3 months'),
(15, 9, 'Study Automation', 'Learn scripting (PowerShell, Python) for automating DBA tasks.', '1-2 months'),
(15, 10, 'Get Database Certified', 'Pursue certification like Oracle DBA, MySQL DBA, or SQL Server certification.', '3-4 months'),
(15, 11, 'Build DBA Experience', 'Set up personal database servers, practice maintenance, and document your work.', '3-6 months'),
(15, 12, 'Apply for DBA Positions', 'Showcase your certifications and database projects. Apply for DBA roles.', '2-3 months');

-- ===================================
-- VERIFY INSERTION
-- ===================================
SELECT '✓✓✓ ROADMAP DATA INSERTED SUCCESSFULLY! ✓✓✓' as Message;

SELECT 
    c.career_id,
    c.career_name,
    COUNT(rs.step_id) as 'Total Steps'
FROM careers c
LEFT JOIN roadmap_steps rs ON c.career_id = rs.career_id
GROUP BY c.career_id, c.career_name
ORDER BY c.career_id;

SELECT 'All 15 careers now have roadmap steps!' as Status;
