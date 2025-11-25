-- INSERT CAREERS ONLY
-- Run this in phpMyAdmin to populate the careers table

USE career_suggestion_db;

-- Clear existing careers (optional - remove comment if you want fresh data)
-- TRUNCATE TABLE careers;

-- Insert 15 IT Careers
INSERT INTO careers (career_name, description, category, avg_salary, job_growth, required_education, skills_required, work_environment, job_outlook) VALUES
('Software Developer', 'Design, develop, and maintain software applications and systems. Work on creating solutions to meet user needs through programming and problem-solving.', 'Development', '$70,000 - $120,000', '22%', 'Bachelor\'s Degree in Computer Science', 'Programming (Java, Python, C++), Problem Solving, Algorithms, Data Structures, Version Control (Git)', 'Office or Remote, typically working independently or in small teams', 'Excellent - High demand across all industries'),

('Web Developer', 'Build and maintain websites and web applications. Focus on front-end (user interface) or back-end (server-side) development.', 'Development', '$50,000 - $90,000', '13%', 'Bachelor\'s Degree or Coding Bootcamp', 'HTML, CSS, JavaScript, React/Vue/Angular, Node.js, Responsive Design, APIs', 'Remote-friendly, freelance opportunities available', 'Very Good - Growing with digital transformation'),

('UI/UX Designer', 'Design user interfaces and user experiences for websites, apps, and software. Focus on usability, accessibility, and visual appeal.', 'Design', '$60,000 - $100,000', '13%', 'Bachelor\'s Degree in Design or related field', 'Design Tools (Figma, Adobe XD, Sketch), User Research, Prototyping, Wireframing, Color Theory', 'Collaborative environment, often working with developers and product managers', 'Good - Essential for product development'),

('QA Tester', 'Test software applications to identify bugs and ensure quality. Create test plans, execute tests, and report issues.', 'Quality Assurance', '$45,000 - $75,000', '9%', 'Bachelor\'s Degree or Certification', 'Testing Methodologies, Automation Tools (Selenium), Bug Tracking, Attention to Detail, SQL', 'Team-oriented, working closely with developers', 'Stable - Quality is always important'),

('Mobile App Developer', 'Develop applications for mobile devices (iOS and Android). Focus on creating user-friendly mobile experiences.', 'Development', '$65,000 - $110,000', '22%', 'Bachelor\'s Degree in Computer Science', 'Swift/Objective-C (iOS), Kotlin/Java (Android), React Native, Flutter, Mobile UI/UX', 'Flexible work environment, high demand for remote work', 'Excellent - Mobile usage continues to grow'),

('Cloud Engineer', 'Design, implement, and manage cloud infrastructure and services. Work with platforms like AWS, Azure, or Google Cloud.', 'Infrastructure', '$80,000 - $130,000', '22%', 'Bachelor\'s Degree + Cloud Certifications', 'AWS/Azure/GCP, Docker, Kubernetes, Infrastructure as Code, Linux, Networking', 'Remote-friendly, often working on complex distributed systems', 'Excellent - Cloud adoption is accelerating'),

('DevOps Engineer', 'Bridge development and operations teams. Automate processes, manage CI/CD pipelines, and ensure smooth deployments.', 'Operations', '$85,000 - $140,000', '21%', 'Bachelor\'s Degree + DevOps Experience', 'CI/CD (Jenkins, GitLab CI), Docker, Kubernetes, Scripting (Python, Bash), Cloud Platforms', 'Fast-paced environment, collaboration between teams', 'Excellent - Critical for modern software delivery'),

('Cybersecurity Analyst', 'Protect systems and networks from security threats. Monitor for breaches, analyze vulnerabilities, and implement security measures.', 'Security', '$70,000 - $120,000', '33%', 'Bachelor\'s Degree in Cybersecurity or IT', 'Network Security, Penetration Testing, SIEM Tools, Risk Assessment, Compliance (ISO, NIST)', 'High-pressure environment, constant learning required', 'Excellent - Security threats are increasing'),

('Data Analyst', 'Analyze and interpret complex data to help organizations make informed decisions. Create reports and visualizations.', 'Data Science', '$55,000 - $95,000', '25%', 'Bachelor\'s Degree in relevant field', 'SQL, Excel, Python/R, Data Visualization (Tableau, Power BI), Statistics, Business Intelligence', 'Office or remote, working with various departments', 'Excellent - Data-driven decisions are crucial'),

('AI/ML Engineer', 'Develop artificial intelligence and machine learning models. Work on algorithms that enable systems to learn and improve.', 'Artificial Intelligence', '$90,000 - $150,000', '40%', 'Bachelor\'s/Master\'s in Computer Science or related', 'Python, TensorFlow/PyTorch, Machine Learning Algorithms, Deep Learning, Statistics, Data Processing', 'Research-oriented, often working on cutting-edge technology', 'Excellent - AI is transforming industries'),

('IT Support Technician', 'Provide technical support to users. Troubleshoot hardware and software issues, maintain systems, and assist with IT requests.', 'Support', '$35,000 - $60,000', '9%', 'Associate Degree or Certifications (A+, Network+)', 'Hardware/Software Troubleshooting, Customer Service, Networking Basics, Windows/Mac OS, Active Directory', 'User-facing role, helping people solve technical problems', 'Stable - Every organization needs IT support'),

('Network Engineer', 'Design, implement, and maintain computer networks. Ensure network reliability, performance, and security.', 'Infrastructure', '$60,000 - $100,000', '5%', 'Bachelor\'s Degree + Networking Certifications (CCNA)', 'Networking Protocols (TCP/IP), Routers/Switches, Network Security, Cisco/Juniper, VPN, Firewalls', 'On-site or hybrid, managing physical and virtual networks', 'Good - Networks are foundational infrastructure'),

('Business Analyst', 'Bridge business needs and IT solutions. Gather requirements, analyze processes, and recommend improvements.', 'Business', '$60,000 - $100,000', '11%', 'Bachelor\'s Degree in Business or IT', 'Requirements Gathering, Process Modeling, SQL, Data Analysis, Communication, Agile/Scrum', 'Collaborative environment, working with stakeholders and technical teams', 'Good - Organizations need to optimize operations'),

('Project Manager', 'Plan, execute, and close IT projects. Manage teams, budgets, timelines, and stakeholder expectations.', 'Management', '$65,000 - $110,000', '7%', 'Bachelor\'s Degree + PMP Certification', 'Project Management, Agile/Scrum, Leadership, Communication, Risk Management, Budgeting', 'Leadership role, coordinating multiple teams and resources', 'Good - Projects need proper management'),

('Database Administrator', 'Design, implement, and maintain databases. Ensure data integrity, security, and optimal performance.', 'Data Management', '$60,000 - $105,000', '8%', 'Bachelor\'s Degree in Computer Science or related', 'SQL, Database Design, Oracle/MySQL/PostgreSQL, Backup/Recovery, Performance Tuning, Security', 'Behind-the-scenes role, ensuring data availability and reliability', 'Stable - Data is critical for all organizations')
ON DUPLICATE KEY UPDATE 
    description = VALUES(description),
    category = VALUES(category),
    avg_salary = VALUES(avg_salary),
    job_growth = VALUES(job_growth),
    required_education = VALUES(required_education),
    skills_required = VALUES(skills_required),
    work_environment = VALUES(work_environment),
    job_outlook = VALUES(job_outlook);

-- Verify insertion
SELECT '✓ Careers Inserted Successfully!' as Status;
SELECT COUNT(*) as 'Total Careers' FROM careers;

-- Show all careers
SELECT career_id, career_name, category, avg_salary, job_growth 
FROM careers 
ORDER BY career_name;